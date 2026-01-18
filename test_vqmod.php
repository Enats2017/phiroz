<?php
// test_vqmod.php - Check if vQmod is working

echo "<h1>vQmod Test</h1>";

// Test 1: Check if vqmod.php exists
$vqmod_path = dirname(__FILE__) . '/vqmod/vqmod.php';
echo "<h3>1. vQmod File Check:</h3>";
if (file_exists($vqmod_path)) {
    echo "✅ vqmod.php exists at: $vqmod_path<br>";
} else {
    echo "❌ vqmod.php NOT FOUND!<br>";
    exit;
}

// Test 2: Try to load vQmod
echo "<h3>2. Loading vQmod:</h3>";
try {
    require_once($vqmod_path);
    echo "✅ vQmod loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ Error loading vQmod: " . $e->getMessage() . "<br>";
    exit;
}

// Test 3: Check vQmod class
echo "<h3>3. vQmod Class Check:</h3>";
if (class_exists('VQMod')) {
    echo "✅ VQMod class exists<br>";
} else {
    echo "❌ VQMod class NOT found!<br>";
    exit;
}

// Test 4: Try bootup
echo "<h3>4. vQmod Bootup:</h3>";
try {
    VQMod::bootup();
    echo "✅ vQmod bootup successful<br>";
} catch (Exception $e) {
    echo "❌ Bootup failed: " . $e->getMessage() . "<br>";
}

// Test 5: Check XML files
echo "<h3>5. XML Files:</h3>";
$xml_path = dirname(__FILE__) . '/vqmod/xml/';
$xml_files = glob($xml_path . '*.xml');
if ($xml_files) {
    echo "Found " . count($xml_files) . " XML files:<br>";
    foreach ($xml_files as $file) {
        echo " - " . basename($file) . "<br>";
    }
} else {
    echo "❌ No XML files found!<br>";
}

// Test 6: Check cache folder
echo "<h3>6. Cache Folder:</h3>";
$cache_path = dirname(__FILE__) . '/vqmod/vqcache/';
if (is_dir($cache_path)) {
    if (is_writable($cache_path)) {
        echo "✅ vqcache folder is writable<br>";
        $cache_files = glob($cache_path . 'vq*');
        echo "Cache files: " . count($cache_files) . "<br>";
    } else {
        echo "❌ vqcache folder is NOT writable!<br>";
    }
} else {
    echo "❌ vqcache folder does NOT exist!<br>";
}

// Test 7: Check logs folder
echo "<h3>7. Logs Folder:</h3>";
$logs_path = dirname(__FILE__) . '/vqmod/logs/';
if (is_dir($logs_path)) {
    if (is_writable($logs_path)) {
        echo "✅ logs folder is writable<br>";
    } else {
        echo "❌ logs folder is NOT writable!<br>";
    }
} else {
    echo "❌ logs folder does NOT exist!<br>";
}

echo "<hr><h3>✅ Test Complete</h3>";
echo "<p>If all tests pass, vQmod should be working. Check admin panel now.</p>";
?>