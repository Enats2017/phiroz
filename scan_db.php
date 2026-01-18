<?php
// scan_db.php
// Scans the OpenCart database for malicious redirect code

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('config.php');

echo "Connecting to database: " . DB_DATABASE . " on " . DB_HOSTNAME . "\n";

$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}
echo "Connected successfully.\n\n";

// Patterns to search for
$patterns = [
    '%ushort%',
    '%window.location%',
    '%\x68\x74\x74%',
    '%Coming Soon%'
];

// Tables to check (most likely suspects)
$tables = [
    DB_PREFIX . 'setting',
    DB_PREFIX . 'layout_module',
    DB_PREFIX . 'layout_route',
    DB_PREFIX . 'module',
    DB_PREFIX . 'banner_image',
    DB_PREFIX . 'information_description',
    DB_PREFIX . 'category_description',
    DB_PREFIX . 'product_description'
];

foreach ($tables as $table) {
    echo "Scanning table: $table ...\n";

    // Check if table exists
    $check_table = $conn->query("SHOW TABLES LIKE '$table'");
    if ($check_table->num_rows == 0) {
        echo "  Table does not exist. Skipping.\n";
        continue;
    }

    // Get all columns
    $columns = [];
    $result = $conn->query("SHOW COLUMNS FROM $table");
    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }

    foreach ($patterns as $pattern) {
        foreach ($columns as $column) {
            $sql = "SELECT * FROM `$table` WHERE `$column` LIKE '$pattern'";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                echo "  🚨 MALICIOUS CODE FOUND in column '$column' with pattern '$pattern'!\n";
                while ($row = $result->fetch_assoc()) {
                    $id_col = $columns[0]; // Assuming first column is ID
                    echo "    - ID: " . $row[$id_col] . "\n";
                    echo "    - Content (Preview): " . substr($row[$column], 0, 100) . "...\n";

                    // Attempt to clean
                    if ($pattern == '%ushort%') {
                        echo "    -> ATTEMPTING TO CLEAN...\n";
                        // This is dangerous, so we just log it for now unless confirmed
                        // $update_sql = "UPDATE `$table` SET `$column` = REPLACE(`$column`, '...', '') WHERE `$id_col` = " . $row[$id_col];
                    }
                }
            }
        }
    }
}

echo "\nScan complete.\n";
$conn->close();
?>