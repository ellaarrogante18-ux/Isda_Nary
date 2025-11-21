<?php
// Test if mod_rewrite is enabled
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<h2 style='color: green;'>✅ mod_rewrite is ENABLED</h2>";
        echo "<p>Laravel routing should work properly.</p>";
    } else {
        echo "<h2 style='color: red;'>❌ mod_rewrite is DISABLED</h2>";
        echo "<p>You need to enable mod_rewrite in Apache for Laravel to work.</p>";
        echo "<p>In XAMPP: Apache Config > httpd.conf > Uncomment: LoadModule rewrite_module modules/mod_rewrite.so</p>";
    }
} else {
    echo "<h2 style='color: orange;'>⚠️ Cannot detect Apache modules</h2>";
    echo "<p>This might be running on a different server setup.</p>";
}

echo "<hr>";
echo "<h3>Current Server Info:</h3>";
echo "<p><strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h2, h3 { margin-top: 20px; }
</style>
