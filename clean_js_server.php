<?php
// clean_js_server.php
// Dedicated JavaScript Cleaner for OpenCart
// Removes: \x68\x74\x74... redirections

if (isset($_GET['key']) && $_GET['key'] != 'enats2026') {
    die('Access Denied');
}

echo "<h1>JavaScript Cleaner Tool</h1><hr>";

function scanAndClean($dir)
{
    if (!is_dir($dir)) {
        echo "Directory not found: $dir<br>";
        return;
    }

    $iter = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iter as $path => $dirObj) {
        if ($dirObj->isFile() && pathinfo($path, PATHINFO_EXTENSION) === 'js') {
            $content = file_get_contents($path);

            // Patterns
            $hex_pattern = '\\x68\\x74\\x74\\x70'; // http in hex
            $url_pattern = 'ushort.today';

            if (strpos($content, $hex_pattern) !== false || strpos($content, $url_pattern) !== false) {
                echo "<strong style='color:red'>INFECTED: $path</strong><br>";

                // Backup
                copy($path, $path . '.bak_infected');

                // Clean Method 1: Remove specific hex string
                $clean_content = str_replace('\x68\x74\x74\x70\x73\x3a\x2f\x2f\x75\x73\x68\x6f\x72\x74\x2e\x74\x6f\x64\x61\x79\x2f\x79\x4b\x7a\x30\x72\x33', '', $content);

                // Clean Method 2: Generic hex redirect removal
                // Removing lines like: window.location.href = "\x68...";
                $clean_content = preg_replace('/window\.location\.href\s*=\s*"\\\\x68.*?";/s', '', $clean_content);

                if ($clean_content != $content) {
                    file_put_contents($path, $clean_content);
                    echo "<span style='color:green'> - CLEANED SUCCESSFUL.</span><br>";
                } else {
                    echo "<span style='color:orange'> - COULD NOT AUTO-CLEAN (Pattern Mismatch). Please check manually.</span><br>";
                }
            }
        }
    }
}

// Start Scan
echo "<h3>Scanning catalog/view/javascript...</h3>";
scanAndClean('catalog/view/javascript');

echo "<h3>Scanning admin/view/javascript...</h3>";
scanAndClean('admin/view/javascript');

echo "<hr><h3>Scan Complete</h3>";
?>