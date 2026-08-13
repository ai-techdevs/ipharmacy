<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CdcSyndicationService;

class ImportCdcPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdc:import {--force : Force sync all pages, ignoring last seen media ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and import new CDC syndicated HTML content matching health/pharmacy keywords';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting CDC syndicated content sync...');
        
        $force = $this->option('force');
        $result = CdcSyndicationService::sync($force);
        
        if ($result['success']) {
            $this->info($result['message']);
            return Command::SUCCESS;
        } else {
            $this->error($result['message']);
            if (!empty($result['errors'])) {
                foreach ($result['errors'] as $error) {
                    $this->error("Error detail: " . $error);
                }
            }
            return Command::FAILURE;
        }
    }
}
