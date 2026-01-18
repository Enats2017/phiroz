<?php
// clean_virus.php
// FORCE CLEAN malicious redirect code from DB and Files

// Security Check
if (isset($_GET['key']) && $_GET['key'] != 'enats2026') {
    die('Access Denied. Use ?key=enats2026');
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('config.php');

// Database Connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

// MALICIOUS PATTERNS
$patterns = array(
    'ushort.today',
    'window.location.href',
    '\x68\x74\x74\x70',
    '\x75\x73\x68\x6f\x72\x74'
);

echo "<h1>Auto-Cleaner Tool</h1>";
echo "<hr>";

// 1. CLEAN DATABASE
echo "<h3>1. Scanning Database...</h3>";

$tables_to_check = array(
    DB_PREFIX . 'setting',
    DB_PREFIX . 'layout_route',
    DB_PREFIX . 'layout_module',
    DB_PREFIX . 'banner_image_description',
    DB_PREFIX . 'category_description'
);

foreach ($tables_to_check as $table) {
    // Check if table exists
    $check = $conn->query("SHOW TABLES LIKE '$table'");
    if ($check->num_rows == 0)
        continue;

    echo "Checking table: <strong>$table</strong>...<br>";

    // Get columns
    $cols = $conn->query("SHOW COLUMNS FROM $table");
    $columns = array();
    while ($r = $cols->fetch_assoc()) {
        $columns[] = $r['Field'];
    }

    foreach ($columns as $col) {
        foreach ($patterns as $pat) {
            $sql = "SELECT * FROM `$table` WHERE `$col` LIKE '%" . $conn->real_escape_string($pat) . "%'";
            $res = $conn->query($sql);

            if ($res && $res->num_rows > 0) {
                echo "<span style='color:red'>FOUND virus in column '$col'! Cleaning...</span><br>";
                while ($row = $res->fetch_assoc()) {
                    // Update to remove the line
                    // We assume the virus is usually a block of <script>...</script>

                    $id_col = $columns[0];
                    $id_val = $row[$id_col];

                    $original_content = $row[$col];
                    // Simple replacement: remove the script tag completely if possible, or just empty the value if it's suspicious
                    // For safety, let's just REPLACE the malicious hex string with empty

                    $clean_content = $original_content;
                    // Common hex strings patterns
                    $clean_content = str_replace('\x68\x74\x74\x70\x73\x3a\x2f\x2f\x75\x73\x68\x6f\x72\x74\x2e\x74\x6f\x64\x61\x79\x2f\x79\x4b\x7a\x30\x72\x33', '', $clean_content);
                    $clean_content = str_replace('window.location.href', '//cleaned_redirect', $clean_content);

                    if ($original_content != $clean_content) {
                        $update = "UPDATE `$table` SET `$col` = '" . $conn->real_escape_string($clean_content) . "' WHERE `$id_col` = '$id_val'";
                        if ($conn->query($update)) {
                            echo " - Cleaned ID: $id_val<br>";
                        } else {
                            echo " - Failed to clean ID: $id_val<br>";
                        }
                    }
                }
            }
        }
    }
}

// 2. CLEAN FILES (Aggressive)
echo "<h3>2. Scanning Files...</h3>";

function recursiveScan($dir)
{
    $files = glob($dir . '/*');
    foreach ($files as $file) {
        if (is_dir($file)) {
            recursiveScan($file);
        } else {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array($ext, array('php', 'js', 'html', 'tpl'))) {
                $content = file_get_contents($file);
                if (strpos($content, 'ushort.today') !== false || strpos($content, '\x68\x74\x74\x70') !== false) {
                    echo "<span style='color:red'>FOUND IN FILE: $file</span><br>";
                    // Backup
                    copy($file, $file . '.infected.bak');
                    // Remove
                    $content = str_replace('\x68\x74\x74\x70\x73\x3a\x2f\x2f\x75\x73\x68\x6f\x72\x74\x2e\x74\x6f\x64\x61\x79\x2f\x79\x4b\x7a\x30\x72\x33', '', $content);
                    $content = preg_replace('/<script>window\.location\.href\s*=\s*".*?";<\/script>/', '', $content);

                    if (file_put_contents($file, $content)) {
                        echo " - File Cleaned.<br>";
                    }
                }
            }
        }
    }
}

// Scan critical folders
recursiveScan('catalog/view/javascript');
recursiveScan('catalog/view/theme');
recursiveScan('vqmod/xml');
recursiveScan('admin/view/template');

echo "<hr><h3>DONE. Please delete this file after use!</h3>";
?>