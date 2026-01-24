<?php

return [
    'webdav_base_uri' => env('NEXTCLOUD_WEBDAV_BASE_URI', 'https://localhost/remote.php/dav/files/'),
    'username' => env('NEXTCLOUD_USERNAME', ''),
    'app_password' => env('NEXTCLOUD_APP_PASSWORD', ''),
    'folder_prefix' => env('NEXTCLOUD_FOLDER_PREFIX', 'documents'),
];
