<?php
// Enable ALL error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "<h2>OpenCart Debug Test</h2>";

// Test 1: PHP Info
echo "<h3>1. PHP Version</h3>";
echo "PHP Version: " . phpversion() . "<br>";

// Test 2: Config file
echo "<h3>2. Config File Test</h3>";
$config_file = __DIR__ . '/admin/config.php';
if (file_exists($config_file)) {
    echo "✅ Admin config.php exists<br>";
    require_once($config_file);
    echo "✅ Config loaded successfully<br>";
    echo "DB_DATABASE: " . DB_DATABASE . "<br>";
    echo "DB_HOSTNAME: " . DB_HOSTNAME . "<br>";
} else {
    echo "❌ Admin config.php NOT found!<br>";
}

// Test 3: Database Connection
echo "<h3>3. Database Connection</h3>";
if (defined('DB_HOSTNAME')) {
    $conn = @mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if ($conn) {
        echo "✅ Database connected!<br>";
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM " . DB_PREFIX . "user");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            echo "✅ Found " . $row['count'] . " admin users<br>";
        }
        mysqli_close($conn);
    } else {
        echo "❌ Database connection FAILED!<br>";
        echo "Error: " . mysqli_connect_error() . "<br>";
    }
}

// Test 4: Critical Files
echo "<h3>4. Critical Files Check</h3>";
$files = [
    'admin/index.php',
    'admin/controller/common/login.php',
    'admin/view/template/common/login.tpl',
    'system/startup.php',
    'system/library/user.php',
];

foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        echo "✅ $file<br>";
    } else {
        echo "❌ MISSING: $file<br>";
    }
}

// Test 5: Directory Permissions
echo "<h3>5. Directory Permissions</h3>";
$dirs = [
    'system/cache',
    'system/logs',
    'vqmod/vqcache',
];

foreach ($dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (is_dir($path)) {
        if (is_writable($path)) {
            echo "✅ $dir (writable)<br>";
        } else {
            echo "⚠️ $dir (NOT writable)<br>";
        }
    } else {
        echo "❌ $dir (NOT found)<br>";
    }
}

// Test 6: Database Scan for Malicious Code
echo "<h3>6. Database Scan for Malicious Code</h3>";
if (isset($conn) && $conn) {
    $conn = @mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    // Check oc_setting
    $malicious_pattern = '%ushort%';
    $sql = "SELECT * FROM " . DB_PREFIX . "setting WHERE `value` LIKE '$malicious_pattern' OR `value` LIKE '%window.location%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "🚨 <strong>MALICIOUS CODE FOUND IN DB (oc_setting)!</strong><br>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Key: " . $row['key'] . " | ID: " . $row['setting_id'] . "<br>";
            echo "<textarea rows='3' cols='50'>" . htmlspecialchars($row['value']) . "</textarea><br>";
        }
    } else {
        echo "✅ No malicious code found in oc_setting table.<br>";
    }

    // Check oc_layout_route (sometimes injected in layouts)
    /*
    $sql = "SELECT * FROM " . DB_PREFIX . "layout_route WHERE `route` LIKE '$malicious_pattern'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "🚨 MALICIOUS CODE FOUND IN DB (oc_layout_route)!<br>";
    }
    */

    mysqli_close($conn);
} else {
    echo "⚠️ Skipping DB scan (No connection)<br>";
}

echo "<br><strong>If all tests pass, try accessing:</strong><br>";
echo "<a href='/phiroz_2020/admin/'>Admin Panel</a>";
?>