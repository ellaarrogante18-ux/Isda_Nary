<?php

// Simple test to check what's working
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Current Directory: " . __DIR__ . "\n";

// Test autoloader
if (file_exists(__DIR__.'/vendor/autoload.php')) {
    echo "✅ Autoloader exists\n";
    require __DIR__.'/vendor/autoload.php';
    echo "✅ Autoloader loaded\n";
} else {
    echo "❌ Autoloader missing\n";
    exit(1);
}

// Test bootstrap
if (file_exists(__DIR__.'/bootstrap/app.php')) {
    echo "✅ Bootstrap file exists\n";
    try {
        $app = require_once __DIR__.'/bootstrap/app.php';
        echo "✅ Bootstrap loaded\n";
        echo "App class: " . get_class($app) . "\n";
    } catch (Exception $e) {
        echo "❌ Bootstrap error: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
} else {
    echo "❌ Bootstrap file missing\n";
}

echo "Test completed.\n";
