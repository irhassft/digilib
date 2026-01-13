<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use Dotenv\Dotenv;

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$baseUri = trim($_ENV['NEXTCLOUD_WEBDAV_BASE_URI'] ?? '');
$username = $_ENV['NEXTCLOUD_USERNAME'] ?? 'irhas';
$appPassword = $_ENV['NEXTCLOUD_APP_PASSWORD'] ?? '';

echo "=== Nextcloud Auth Test (Guzzle auth parameter) ===\n";
echo "Base URI: {$baseUri}\n";
echo "Username: {$username}\n";
echo "App Password: " . (strlen($appPassword) > 10 ? substr($appPassword, 0, 10) . '...' : $appPassword) . "\n\n";

$client = new Client(['verify' => false]);

// Test 1: PROPFIND (folder listing)
echo "1. Testing PROPFIND...\n";
try {
    $response = $client->request('PROPFIND', $baseUri, [
        'auth' => [$username, $appPassword],
        'headers' => [
            'Depth' => '0',
        ],
        'http_errors' => false,
    ]);
    
    echo "   Status: " . $response->getStatusCode() . "\n";
    if (!in_array($response->getStatusCode(), [200, 207])) {
        $body = $response->getBody()->getContents();
        echo "   Response: " . substr($body, 0, 200) . "\n";
    } else {
        echo "   ✓ PROPFIND successful\n";
    }
} catch (\Throwable $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 2: MKCOL (create folder)
echo "\n2. Testing MKCOL (create test folder)...\n";
$testFolder = "{$baseUri}test_auth_" . time();
try {
    $response = $client->request('MKCOL', $testFolder, [
        'auth' => [$username, $appPassword],
        'http_errors' => false,
    ]);
    
    echo "   Status: " . $response->getStatusCode() . "\n";
    if (in_array($response->getStatusCode(), [201, 405])) {
        echo "   ✓ MKCOL successful\n";
    } else {
        $body = $response->getBody()->getContents();
        echo "   ✗ Response: " . substr($body, 0, 300) . "\n";
    }
} catch (\Throwable $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 3: PUT (upload file)
echo "\n3. Testing PUT (upload test file)...\n";
$testFile = "{$baseUri}test_auth_" . time() . ".txt";
try {
    $response = $client->request('PUT', $testFile, [
        'auth' => [$username, $appPassword],
        'body' => 'Test content: ' . date('Y-m-d H:i:s'),
        'http_errors' => false,
    ]);
    
    echo "   Status: " . $response->getStatusCode() . "\n";
    if (in_array($response->getStatusCode(), [200, 201, 204])) {
        echo "   ✓ PUT successful\n";
    } else {
        $body = $response->getBody()->getContents();
        echo "   ✗ Response: " . substr($body, 0, 300) . "\n";
    }
} catch (\Throwable $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\nTest complete.\n";
?>
