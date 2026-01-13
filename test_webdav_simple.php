<?php
/**
 * Simple Nextcloud WebDAV file list - Fixed
 */

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use GuzzleHttp\Client;

$baseUri = rtrim($_ENV['NEXTCLOUD_WEBDAV_BASE_URI'] ?? '', '/');
$username = $_ENV['NEXTCLOUD_USERNAME'] ?? 'irhas';
$password = $_ENV['NEXTCLOUD_APP_PASSWORD'] ?? '';

echo "\n=== Nextcloud WebDAV File Listing ===\n\n";
echo "Server: {$baseUri}\n";
echo "User: {$username}\n\n";

$client = new Client(['verify' => false]);

function parseWebdavResponse($xml) {
    $results = [];
    
    try {
        $dom = new DOMDocument();
        @$dom->loadXML($xml);
        
        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('d', 'DAV:');
        $xpath->registerNamespace('s', 'http://sabredav.org/ns');
        
        $responses = $xpath->query('//d:response');
        
        foreach ($responses as $response) {
            $href = $xpath->query('.//d:href', $response)->item(0)->nodeValue ?? '';
            $displayname = $xpath->query('.//d:displayname', $response)->item(0)->nodeValue ?? '';
            $resourcetype = $xpath->query('.//d:resourcetype', $response)->item(0);
            $isFolder = $xpath->query('.//d:collection', $resourcetype)->length > 0;
            $size = $xpath->query('.//d:getcontentlength', $response)->item(0)->nodeValue ?? '0';
            
            $name = basename(trim($href, '/'));
            if ($name) {
                $results[] = [
                    'name' => $name,
                    'href' => $href,
                    'isFolder' => $isFolder,
                    'size' => (int)$size,
                ];
            }
        }
    } catch (\Exception $e) {
        echo "Error parsing XML: " . $e->getMessage() . "\n";
    }
    
    return $results;
}

// List documents folder
$response = $client->request('PROPFIND', "{$baseUri}/documents", [
    'auth' => [$username, $password],
    'headers' => ['Depth' => '1'],
    'http_errors' => false,
]);

if ($response->getStatusCode() === 207) {
    $items = parseWebdavResponse((string)$response->getBody());
    
    echo "📁 DOCUMENTS FOLDER:\n";
    echo str_repeat("-", 70) . "\n";
    
    $folders = [];
    foreach ($items as $item) {
        if ($item['isFolder'] && $item['name'] !== 'documents') {
            $folders[] = $item['name'];
            echo "   └─ 📁 {$item['name']}/\n";
        }
    }
    
    echo "\n";
    
    // List files in each folder
    foreach ($folders as $folder) {
        echo "📂 FOLDER: {$folder}\n";
        echo str_repeat("-", 70) . "\n";
        
        $folderResponse = $client->request('PROPFIND', "{$baseUri}/documents/{$folder}", [
            'auth' => [$username, $password],
            'headers' => ['Depth' => '1'],
            'http_errors' => false,
        ]);
        
        if ($folderResponse->getStatusCode() === 207) {
            $files = parseWebdavResponse((string)$folderResponse->getBody());
            
            $fileCount = 0;
            foreach ($files as $file) {
                if (!$file['isFolder'] && $file['name'] !== $folder) {
                    $fileCount++;
                    $sizeKB = round($file['size'] / 1024, 2);
                    echo sprintf("   %2d. 📄 %-50s (%8s KB)\n", $fileCount, $file['name'], $sizeKB);
                }
            }
            
            if ($fileCount === 0) {
                echo "   (No files)\n";
            }
            echo "\n";
        }
    }
    
} else {
    echo "Error: HTTP " . $response->getStatusCode() . "\n";
}

echo "=== End ===\n\n";
