<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestWebDav extends Command
{
    protected $signature = 'test:webdav';
    protected $description = 'Test Nextcloud WebDAV connection';

    public function handle()
    {
        $this->info('Testing Nextcloud WebDAV connection...');

        try {
            $files = Storage::disk('nextcloud')->files('/');
            $this->info('Connection successful! Root files:');
            foreach ($files as $file) {
                $this->line("- $file");
            }

            $prefix = trim(env('NEXTCLOUD_FOLDER_PREFIX', 'documents'), '/');
            $targetFolder = "$prefix/test_subfolder";
            $this->info("\nChecking folder: $targetFolder");
            
            if (Storage::disk('nextcloud')->exists($targetFolder)) {
                $this->info("Folder exists.");
            } else {
                $this->warn("Folder does not exist. Attempting to create...");
                try {
                    Storage::disk('nextcloud')->makeDirectory($targetFolder);
                    $this->info("Folder created successfully.");
                } catch (\Exception $e) {
                    $this->error("Failed to create folder: " . $e->getMessage());
                }
            }

            $this->info("\nAttempting upload test...");
            $testContent = 'Hello World from Laravel';
            $testFile = $targetFolder . '/test_upload.txt';
            
            $result = Storage::disk('nextcloud')->put($testFile, $testContent);
            
            if ($result) {
                $this->info("Upload successful: $testFile");
                Storage::disk('nextcloud')->delete($testFile);
                $this->info("Test file deleted.");
            } else {
                $this->error("Upload failed.");
            }

        } catch (\Exception $e) {
            $this->error("Connection failed: " . $e->getMessage());
            $this->error("Settings:");
            $this->line("Base URI: " . config('filesystems.disks.nextcloud.baseUri'));
            $this->line("Username: " . config('filesystems.disks.nextcloud.userName'));
        }
    }
}
