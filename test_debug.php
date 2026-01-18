<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Testing PHP...<br>";
echo "Current directory: " . __DIR__ . "<br>";

// Test database connection
$db_host = 'localhost';
$db_user = 'enats';
$db_pass = 'Enats@2021';
$db_name = 'db_phiroz_2020_bk_2022_10_25';

echo "Attempting database connection...<br>";

$conn = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($conn) {
    echo "✅ Database connected successfully!<br>";
    echo "Database: " . $db_name . "<br>";
    mysqli_close($conn);
} else {
    echo "❌ Database connection failed!<br>";
    echo "Error: " . mysqli_connect_error() . "<br>";
}

// Test file paths
echo "<br>Testing file paths:<br>";
$paths = [
    '/var/www/html/phiroz_2020/config.php',
    '/var/www/html/phiroz_2020/index.php',
    '/var/www/html/phiroz_2020/system/startup.php',
    '/var/www/html/phiroz_2020/catalog/',
];

foreach ($paths as $path) {
    if (file_exists($path)) {
        echo "✅ Found: $path<br>";
    } else {
        echo "❌ Missing: $path<br>";
    }
}

echo "<br>PHP Version: " . phpversion() . "<br>";
echo "Server: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
?>