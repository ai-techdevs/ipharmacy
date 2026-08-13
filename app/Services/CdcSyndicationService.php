<?php

namespace App\Services;

use App\Models\TempCdcPost;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CdcSyndicationService
{
    /**
     * Fetch media content from CDC and import new matching posts.
     *
     * @param bool $force Whether to bypass the check for new content and sync all pages.
     * @return array Summary of the sync process results.
     */
    public static function sync(bool $force = false): array
    {
        $importedCount = 0;
        $skippedCount = 0;
        $matchedCount = 0;
        $errors = [];

        try {
            $currentPage = 1;
            $totalPages = 1;
            $firstPageNewestMediaId = null;

            // Keywords to filter by (matching requirements case-insensitively)
            // flu, vaccines, COVID, RSV, diabetes, medication safety, outbreaks, pharmacy
            $keywords = ['flu', 'influenza', 'vaccine', 'covid', 'rsv', 'diabetes', 'medication safety', 'outbreak', 'pharmacy'];

            // Retrieve the last seen latest media ID from Cache
            $lastSeenMediaId = \Illuminate\Support\Facades\Cache::get('cdc_latest_media_id');
             // Retrieve the last seen latest media ID from the database settings
            //$lastSeenMediaId = \App\Models\Setting::where('key', 'cdc_latest_media_id')->value('value');

            do {
                // Fetch English HTML media items from CDC Content Services API v2 sorted by latest
                $url = "https://tools.cdc.gov/api/v2/resources/media.json?mediatypes=HTML&languagename=English&max=100&sort=-datepublished&pagenum=" . $currentPage;
                $response = Http::get($url);

                if (!$response->successful()) {
                    Log::error("CDC API Request failed on page {$currentPage}. Status: " . $response->status());
                    $errors[] = "Failed to fetch page {$currentPage}. Status: " . $response->status();
                    if ($currentPage === 1) {
                        return [
                            'success' => false,
                            'message' => "Failed to fetch from CDC API. Status: " . $response->status(),
                            'imported' => 0,
                            'errors' => $errors
                        ];
                    }
                    break;
                }

                $data = $response->json();
                $items = $data['results'] ?? [];

                // Extract pagination information
                $pagination = $data['pagination'] ?? ($data['meta']['pagination'] ?? []);
                $totalPages = $pagination['totalPages'] ?? 1;

                if (empty($items)) {
                    break;
                }

                // If page 1, check if any new content is available
                if ($currentPage === 1) {
                    $firstPageNewestMediaId = (string)($items[0]['id'] ?? '');

                    if (!$force && !empty($lastSeenMediaId) && $firstPageNewestMediaId === $lastSeenMediaId) {
                        return [
                            'success' => true,
                            'message' => "No new CDC content available (already synced up to Media ID: {$lastSeenMediaId}).",
                            'imported' => 0,
                            'errors' => []
                        ];
                    }
                }

                foreach ($items as $item) {
                    if (empty($item['id'])) {
                        continue;
                    }

                    $mediaId = (string)$item['id'];

                    // If not forcing a full sync, stop if we reached the last seen media ID.
                    // Since the items are sorted by -datepublished (newest first), this indicates
                    // that all remaining items have been processed in previous sync runs.
                    if (!$force && !empty($lastSeenMediaId) && $mediaId === $lastSeenMediaId) {
                        Log::info("Reached previously synced CDC content at Media ID: {$mediaId}. Stopping sync.");
                        break 2; // Break both foreach and do-while loops
                    }

                    // 1. Check if the media item matches the pharmacy/health keywords
                    $searchText = ($item['name'] ?? '') . ' ' . ($item['description'] ?? '');
                    
                    // Also check tags
                    if (!empty($item['tags']) && is_array($item['tags'])) {
                        foreach ($item['tags'] as $tag) {
                            $searchText .= ' ' . ($tag['name'] ?? '');
                        }
                    }

                    $isMatch = false;
                    foreach ($keywords as $keyword) {
                        if (stripos($searchText, $keyword) !== false) {
                            $isMatch = true;
                            break;
                        }
                    }

                    if (!$isMatch) {
                        continue;
                    }

                    $matchedCount++;

                    // 2. Check if already imported to prevent duplicates
                    $exists = TempCdcPost::where('cdc_media_id', $mediaId)->exists();
                    if ($exists) {
                        $skippedCount++;
                        continue;
                    }

                    // 3. Pull the syndicated HTML content (with fallbacks)
                    $htmlContent = '';
                    $contentUrl = $item['contentUrl'] ?? "https://tools.cdc.gov/api/v2/resources/media/{$mediaId}/content.html";
                    
                    try {
                        $contentResponse = Http::get($contentUrl);
                        if ($contentResponse->successful()) {
                            $htmlContent = $contentResponse->body();
                        } else {
                            // Fallback to syndicate JSON endpoint
                            $syndicateUrl = $item['syndicateUrl'] ?? "https://tools.cdc.gov/api/v2/resources/media/{$mediaId}/syndicate.json";
                            $syndicateResponse = Http::get($syndicateUrl);
                            if ($syndicateResponse->successful()) {
                                $resData = $syndicateResponse->json();
                                $htmlContent = $resData['results']['content'] ?? '';
                            }
                        }
                    } catch (\Exception $e) {
                        Log::warning("Failed to fetch syndicated HTML content for CDC Media ID {$mediaId}: " . $e->getMessage());
                    }

                    // Fallback to description if no HTML content fetched
                    if (empty(trim($htmlContent))) {
                        $htmlContent = "<p>" . ($item['description'] ?? 'No description available.') . "</p>";
                    }

                    // 4. Clean and append CDC attribution & source link
                    $attributionHtml = $item['attribution'] ?? '<div class="cdc-attribution">Content provided and maintained by the US Centers for Disease Control and Prevention (CDC).</div>';
                    $sourceUrl = $item['sourceUrl'] ?? $item['targetUrl'] ?? "https://www.cdc.gov";
                    $sourceLink = '<p class="mt-3 cdc-source-link"><small>Source URL: <a href="' . $sourceUrl . '" target="_blank">' . $sourceUrl . '</a></small></p>';

                    $description = $htmlContent . "\n\n" . '<hr class="cdc-divider" />' . "\n" . $attributionHtml . "\n" . $sourceLink;

                    // 5. Store in database (disabled by default)
                    TempCdcPost::create([
                        'title' => mb_substr($item['name'] ?? 'CDC Post - ' . $mediaId, 0, 255),
                        'author' => 'CDC',
                        'description' => $description,
                        'status' => 0, // Disabled by default
                        'cdc_media_id' => $mediaId,
                        'source_url' => $sourceUrl,
                        'image' => isset($item['thumbnailUrl']) ? mb_substr($item['thumbnailUrl'], 0, 255) : null,
                    ]);

                    $importedCount++;
                }

                $currentPage++;

            } while ($currentPage <= $totalPages);

            // Update the last seen media ID in Cache if we successfully synced
            if (!empty($firstPageNewestMediaId)) {
                \Illuminate\Support\Facades\Cache::forever('cdc_latest_media_id', $firstPageNewestMediaId);
            }
            // if (!empty($firstPageNewestMediaId)) {
            //     \App\Models\Setting::updateOrCreate(
            //         ['key' => 'cdc_latest_media_id'],
            //         [
            //             'value' => $firstPageNewestMediaId,
            //             'display_name' => 'CDC Latest Media ID',
            //             'type' => 'text',
            //             'group' => 'CDC Sync',
            //             'is_visible' => 0
            //         ]
            //     );
            // }

            return [
                'success' => true,
                'message' => "Successfully processed CDC content. Matches: {$matchedCount}, Imported: {$importedCount}, Duplicates Skipped: {$skippedCount}.",
                'imported' => $importedCount,
                'errors' => $errors
            ];

        } catch (\Exception $e) {
            Log::error("Error syncing CDC content: " . $e->getMessage());
            return [
                'success' => false,
                'message' => "Error occurred: " . $e->getMessage(),
                'imported' => $importedCount,
                'errors' => [$e->getMessage()]
            ];
        }
    }
}
