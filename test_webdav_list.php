<?php
/**
 * Test script to list all files in Nextcloud WebDAV
 * Usage: php test_webdav_list.php
 */

require 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use GuzzleHttp\Client;

$baseUri = rtrim($_ENV['NEXTCLOUD_WEBDAV_BASE_URI'] ?? env('NEXTCLOUD_WEBDAV_BASE_URI'), '/');
$username = $_ENV['NEXTCLOUD_USERNAME'] ?? env('NEXTCLOUD_USERNAME');
$password = $_ENV['NEXTCLOUD_APP_PASSWORD'] ?? env('NEXTCLOUD_APP_PASSWORD');
$folderPrefix = trim($_ENV['NEXTCLOUD_FOLDER_PREFIX'] ?? env('NEXTCLOUD_FOLDER_PREFIX', 'documents'), '/');

echo "=== Nextcloud WebDAV Directory Listing ===\n";
echo "Base URI: {$baseUri}\n";
echo "Username: {$username}\n";
echo "Folder Prefix: {$folderPrefix}\n\n";

$client = new Client(['verify' => false]);

function listWebdavFolder($client, $baseUri, $username, $password, $path, $depth = 1)
{
    try {
        $url = "{$baseUri}/{$path}";
        
        echo "Listing: {$path}\n";
        echo str_repeat("-", 80) . "\n";
        
        $response = $client->request('PROPFIND', $url, [
            'auth' => [$username, $password],
            'headers' => [
                'Depth' => $depth,
            ],
            'http_errors' => false,
        ]);
        
        $statusCode = $response->getStatusCode();
        echo "HTTP Status: {$statusCode}\n\n";
        
        if ($statusCode === 207) { // Multi-Status
            $xml = simplexml_load_string($response->getBody()->getContents());
            
            // Register namespace
            $xml->registerXPathNamespace('d', 'DAV:');
            
            $responses = $xml->xpath('//d:response');
            
            if (empty($responses)) {
                echo "No items found or response parsing failed.\n";
                echo "Raw Response:\n";
                echo $response->getBody()->getContents() . "\n";
            } else {
                $count = 0;
                foreach ($responses as $element) {
                    $href = (string)$element->href;
                    
                    // Skip the folder itself, show only children
                    if ($href === "/{$path}/" || $href === "{$baseUri}/{$path}/") {
                        continue;
                    }
                    
                    $propstat = $element->propstat;
                    $props = $propstat->prop;
                    
                    $displayname = (string)$props->displayname;
                    $resourcetype = $props->resourcetype;
                    $isFolder = $resourcetype->collection ? 'FOLDER' : 'FILE';
                    $size = (string)$props->getcontentlength ?? '';
                    $modified = (string)$props->getlastmodified ?? '';
                    
                    $count++;
                    
                    // Extract just the filename from href
                    $parts = explode('/', trim($href, '/'));
                    $filename = end($parts);
                    
                    echo sprintf(
                        "%2d. [%s] %s (Size: %s bytes, Modified: %s)\n",
                        $count,
                        $isFolder,
                        $displayname ?: $filename,
                        $size ?: 'N/A',
                        $modified ?: 'N/A'
                    );
                }
                
                echo "\nTotal items: {$count}\n";
            }
        } else {
            echo "Error: HTTP {$statusCode}\n";
            echo "Response: " . $response->getBody()->getContents() . "\n";
        }
        
    } catch (\Throwable $e) {
        echo "Exception: {$e->getMessage()}\n";
        echo $e->getTraceAsString() . "\n";
    }
    
    echo "\n";
}

// List root documents folder
listWebdavFolder($client, $baseUri, $username, $password, $folderPrefix, 2);

// List subdirectories if they exist
$subfolders = ['general', 'ajax', 'oncology', 'news'];

foreach ($subfolders as $subfolder) {
    listWebdavFolder($client, $baseUri, $username, $password, "{$folderPrefix}/{$subfolder}", 1);
}

echo "=== End of Listing ===\n";
