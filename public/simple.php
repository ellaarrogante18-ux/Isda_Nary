<?php

// Simple test page
echo "<!DOCTYPE html>";
echo "<html><head><title>Fish Inventory Test</title></head><body>";
echo "<h1>🐟 Fish Inventory System</h1>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Server Time: " . date('Y-m-d H:i:s') . "</p>";

// Test if we can load Laravel
try {
    require_once __DIR__.'/../vendor/autoload.php';
    echo "<p>✅ Composer autoloader loaded</p>";
    
    $app = require_once __DIR__.'/../bootstrap/app.php';
    echo "<p>✅ Laravel application loaded</p>";
    echo "<p>App Environment: " . $app->environment() . "</p>";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>File: " . $e->getFile() . " Line: " . $e->getLine() . "</p>";
}

echo "</body></html>";
