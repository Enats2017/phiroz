<?php
// fix_permissions.php
// Script to fix folder permissions and create missing directories for vQmod

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>🛠️ OpenCart Permission Fixer</h1>";
echo "<p>Attempts to create missing folders and set writable permissions (0777).</p><hr>";

$folders = array(
    'vqmod/logs',
    'vqmod/vqcache',
    'system/cache',
    'system/logs',
    'image/cache',
    'image/data',
    'download'
);

foreach ($folders as $folder) {
    echo "Processing <strong>$folder</strong>... ";

    // 1. Create Folder if missing
    if (!file_exists($folder)) {
        echo "(Missing)... ";
        if (@mkdir($folder, 0777, true)) {
            echo "<span style='color:green'>✅ Created.</span> ";
        } else {
            echo "<span style='color:red'>❌ Failed to create.</span> ";
            $error = error_get_last();
            echo "<small>(" . $error['message'] . ")</small> ";
        }
    } else {
        echo "(Exists)... ";
    }

    // 2. Set Permissions to 777
    if (@chmod($folder, 0777)) {
        echo "<span style='color:green'>✅ Permissions set to 777.</span><br>";
    } else {
        echo "<span style='color:red'>❌ Failed to chmod.</span> (Try FTP)<br>";
    }
}

echo "<hr><h3>🧹 Cleaning Cache...</h3>";

// Clear vQmod Cache
$files = glob('vqmod/vqcache/vq*');
$count = 0;
if ($files) {
    foreach ($files as $file) {
        if (is_file($file)) {
            @unlink($file);
            $count++;
        }
    }
}
echo "Cleared <strong>$count</strong> vQmod cache files.<br>";

// Clear Sytem Cache
$files = glob('system/cache/cache.*');
$count = 0;
if ($files) {
    foreach ($files as $file) {
        if (is_file($file)) {
            @unlink($file);
            $count++;
        }
    }
}
echo "Cleared <strong>$count</strong> System cache files.<br>";

echo "<hr><h3>✅ Done!</h3>";
echo "Now try to login to <a href='admin/'>Admin Panel</a>";
?>