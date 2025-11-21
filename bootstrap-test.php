<?php

// Test environment loading step by step
echo "=== Environment Loading Test ===\n";

// Step 1: Load autoloader
require __DIR__.'/vendor/autoload.php';
echo "✅ Autoloader loaded\n";

// Step 2: Check if .env exists
if (file_exists(__DIR__.'/.env')) {
    echo "✅ .env file exists\n";
} else {
    echo "❌ .env file missing\n";
    exit(1);
}

// Step 3: Try to load environment manually
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    echo "✅ Environment loaded manually\n";
    echo "APP_NAME: " . ($_ENV['APP_NAME'] ?? 'not set') . "\n";
    echo "APP_KEY: " . (isset($_ENV['APP_KEY']) ? 'set' : 'not set') . "\n";
} catch (Exception $e) {
    echo "❌ Environment loading failed: " . $e->getMessage() . "\n";
}

// Step 4: Try Laravel bootstrap
try {
    $app = require __DIR__.'/bootstrap/app.php';
    echo "✅ Laravel bootstrap successful\n";
} catch (Exception $e) {
    echo "❌ Laravel bootstrap failed: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "=== Test Complete ===\n";
