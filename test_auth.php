<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use GuzzleHttp\Client;

$baseUri = trim($_ENV['NEXTCLOUD_WEBDAV_BASE_URI'] ?? '');
$username = $_ENV['NEXTCLOUD_USERNAME'] ?? '';
$password = $_ENV['NEXTCLOUD_APP_PASSWORD'] ?? '';

echo "Testing Nextcloud WebDAV Authentication\n";
echo "========================================\n\n";
echo "Base URI: {$baseUri}\n";
echo "Username: {$username}\n";
echo "Password: {$password}\n\n";

$client = new Client(['verify' => false]);

// Test 1: Try to list documents folder
echo "Test 1: PROPFIND on documents folder\n";
$response = $client->request('PROPFIND', "{$baseUri}/documents", [
    'auth' => [$username, $password],
    'headers' => ['Depth' => '0'],
    'http_errors' => false,
]);

echo "HTTP Status: " . $response->getStatusCode() . "\n";
echo "Response:\n";
echo $response->getBody()->getContents() . "\n\n";

// Test 2: Try MKCOL on a test folder
echo "Test 2: MKCOL on documents/auth-test\n";
$response = $client->request('MKCOL', "{$baseUri}/documents/auth-test", [
    'auth' => [$username, $password],
    'http_errors' => false,
]);

echo "HTTP Status: " . $response->getStatusCode() . "\n";
if ($response->getStatusCode() >= 400) {
    echo "Response:\n";
    echo $response->getBody()->getContents() . "\n";
}
echo "\n";

// Test 3: Try to auth without credentials
echo "Test 3: PROPFIND without auth\n";
$response = $client->request('PROPFIND', "{$baseUri}/documents", [
    'headers' => ['Depth' => '0'],
    'http_errors' => false,
]);

echo "HTTP Status: " . $response->getStatusCode() . "\n";
