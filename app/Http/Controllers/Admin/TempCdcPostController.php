<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TempCdcPostDataTable;
use App\Http\Controllers\Controller;
use App\Models\TempCdcPost;
use App\Models\Cdc;
use App\Services\CdcSyndicationService;
use Illuminate\Http\Request;

class TempCdcPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TempCdcPostDataTable $dataTable)
    {
        return $dataTable->render("admin.temp_cdc_posts.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = TempCdcPost::findOrFail($id);
        return view('admin.temp_cdc_posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:0,1',
        ]);

        $post = TempCdcPost::findOrFail($id);
        
        $input = $request->only(['title', 'author', 'description', 'status']);
        
        $post->update($input);

        $this->syncToMainCdc($post);

        return redirect(route('admin.temp-cdc-posts.index'))->with('success', 'Post updated and synced successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = TempCdcPost::findOrFail($id);
        
        // Delete in main cdcs table if it exists
        $mainPost = Cdc::where('title', $post->title)->first();
        if ($mainPost) {
            $mainPost->delete();
        }
        
        $post->delete();

        return redirect(route('admin.temp-cdc-posts.index'))->with('success', 'Post deleted successfully.');
    }

    /**
     * Toggle the status of a post.
     */
    public function toggleStatus(string $id)
    {
        $post = TempCdcPost::findOrFail($id);
        $post->status = $post->status == 1 ? 0 : 1;
        $post->save();

        $this->syncToMainCdc($post);

        $statusName = $post->status == 1 ? 'Activated' : 'Disabled';
        return redirect()->back()->with('success', "Post status changed to {$statusName} and synced successfully.");
    }

    /**
     * Manually trigger the CDC import sync.
     */
    public function manualSync()
    {
        // Remove PHP's execution time limit for this request only
        set_time_limit(0);
        $result = CdcSyndicationService::sync();
        
        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    /**
     * Helper to sync a Temp CDC post to the main cdcs table.
     */
    private function syncToMainCdc(TempCdcPost $tempPost)
    {
        if ($tempPost->status == 1) {
            // Find or create in main table by title
            Cdc::updateOrCreate(
                ['title' => $tempPost->title],
                [
                    'author' => $tempPost->author,
                    'description' => $tempPost->description,
                    'status' => 1, // Set to Active in main blog
                    'image' => $tempPost->image,
                    'related_blogs_ids' => $tempPost->related_blogs_ids ? implode(',', (array)$tempPost->related_blogs_ids) : null,
                ]
            );
        } else {
            // If disabled, also disable in the main cdcs table
            $mainPost = Cdc::where('title', $tempPost->title)->first();
            if ($mainPost) {
                $mainPost->update(['status' => 0]);
            }
        }
    }
}
