<?php

// Simple test to check what's working
require __DIR__.'/vendor/autoload.php';

// Load Laravel app
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing registration components...\n";

// Test 1: Check if password_hash works
$testPassword = 'password123';
$hashedPassword = password_hash($testPassword, PASSWORD_DEFAULT);
echo "✅ password_hash() works: " . substr($hashedPassword, 0, 20) . "...\n";

// Test 2: Check database connection
try {
    $pdo = DB::connection()->getPdo();
    echo "✅ Database connection works\n";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
}

// Test 3: Check User model
try {
    $user = new App\Models\User();
    echo "✅ User model loads\n";
} catch (Exception $e) {
    echo "❌ User model error: " . $e->getMessage() . "\n";
}

echo "Test completed.\n";
