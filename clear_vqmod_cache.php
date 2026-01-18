<?php
// clear_vqmod_cache.php
// Force clear vQmod cache via browser

echo "<h1>🧹 vQmod Cache Cleaner</h1>";
echo "<hr>";

// 1. Clear vQmod cache
echo "<h3>1. Clearing vQmod Cache...</h3>";
$vqcache_path = dirname(__FILE__) . '/vqmod/vqcache/';
$count = 0;

if (is_dir($vqcache_path)) {
    $files = glob($vqcache_path . 'vq*');
    foreach ($files as $file) {
        if (is_file($file)) {
            if (@unlink($file)) {
                $count++;
            }
        }
    }
    echo "✅ Deleted <strong>$count</strong> vQmod cache files.<br>";
} else {
    echo "❌ vqcache directory not found!<br>";
}

// 2. Clear system cache
echo "<h3>2. Clearing System Cache...</h3>";
$syscache_path = dirname(__FILE__) . '/system/cache/';
$count = 0;

if (is_dir($syscache_path)) {
    $files = glob($syscache_path . 'cache.*');
    foreach ($files as $file) {
        if (is_file($file)) {
            if (@unlink($file)) {
                $count++;
            }
        }
    }
    echo "✅ Deleted <strong>$count</strong> system cache files.<br>";
}

// 3. Touch XML to force reload
echo "<h3>3. Forcing vQmod XML Reload...</h3>";
$xml_file = dirname(__FILE__) . '/vqmod/xml/admin_theme_base5builder_impulsepro_1.5.5-above.xml';
if (file_exists($xml_file)) {
    touch($xml_file);
    echo "✅ XML file timestamp updated.<br>";
} else {
    echo "❌ XML file not found!<br>";
}

// 4. Check theme files
echo "<h3>4. Verifying Theme Files...</h3>";
$theme_login = dirname(__FILE__) . '/admin/view/template/admin_theme/base5builder_impulsepro/common/login.tpl';
if (file_exists($theme_login)) {
    echo "✅ Theme login.tpl exists (" . filesize($theme_login) . " bytes)<br>";
} else {
    echo "❌ Theme login.tpl NOT FOUND!<br>";
}

echo "<hr>";
echo "<h2>✅ Cache Cleared Successfully!</h2>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Close this page</li>";
echo "<li>Clear your browser cache (Ctrl + Shift + Delete)</li>";
echo "<li>Open <a href='admin/' target='_blank'>Admin Panel</a></li>";
echo "<li>Press Ctrl + F5 for hard refresh</li>";
echo "</ol>";
echo "<p>Your ImpulsePro theme should now load!</p>";
?>