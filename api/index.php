<?php

// Paksa Storage ke /tmp (Karena Vercel Read-Only)
$storagePath = '/tmp/storage';
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0777, true);
    mkdir($storagePath . '/framework/views', 0777, true);
    mkdir($storagePath . '/framework/cache', 0777, true);
}

putenv('APP_KEY=base64:YQT2M6rOxvqFxU+xR7YrMsLzcW3rpEZ/uCiZ51s2894=');

// Set environment variable
putenv('APP_STORAGE=' . $storagePath);
putenv('VIEW_COMPILED_PATH=' . $storagePath . '/framework/views');

// Setup Vercel
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';

// Jalankan Laravel
require __DIR__ . '/../public/index.php';