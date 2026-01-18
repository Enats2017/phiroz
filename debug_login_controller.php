<?php
// debug_login_controller.php
// Check what template is being used by login controller

echo "<h1>🔍 Login Controller Debug</h1><hr>";

// Load vQmod
require_once('vqmod/vqmod.php');
VQMod::bootup();

echo "<h3>1. vQmod Status:</h3>";
echo "✅ vQmod loaded<br>";

// Check what file vQmod returns for login controller
$original_file = 'admin/controller/common/login.php';
$vqmod_file = VQMod::modCheck($original_file);

echo "<h3>2. Login Controller Path:</h3>";
echo "Original: <code>$original_file</code><br>";
echo "vQmod Returns: <code>$vqmod_file</code><br>";

if ($original_file != $vqmod_file) {
    echo "✅ vQmod IS modifying the file<br>";
} else {
    echo "❌ vQmod is NOT modifying the file!<br>";
}

// Read the vQmod cached file
echo "<h3>3. Checking Template Assignment:</h3>";
if (file_exists($vqmod_file)) {
    $content = file_get_contents($vqmod_file);

    // Search for template assignment
    if (strpos($content, 'admin_theme/base5builder_impulsepro/common/login.tpl') !== false) {
        echo "✅ Template IS set to ImpulsePro theme<br>";
    } elseif (strpos($content, "template = 'common/login.tpl'") !== false) {
        echo "❌ Template is still DEFAULT (not modified by vQmod)<br>";
        echo "<strong style='color:red'>Problem: vQmod XML is not being applied!</strong><br>";
    } else {
        echo "⚠️ Template assignment not found in expected format<br>";
    }

    // Show relevant lines
    echo "<h3>4. Template Assignment Code:</h3>";
    $lines = explode("\n", $content);
    foreach ($lines as $num => $line) {
        if (stripos($line, 'template') !== false && stripos($line, 'login') !== false) {
            echo "Line " . ($num + 1) . ": <code>" . htmlspecialchars($line) . "</code><br>";
        }
    }
} else {
    echo "❌ vQmod file not found!<br>";
}

// Check XML file
echo "<h3>5. XML File Status:</h3>";
$xml_file = 'vqmod/xml/admin_theme_base5builder_impulsepro_1.5.5-above.xml';
if (file_exists($xml_file)) {
    echo "✅ XML file exists<br>";
    echo "Size: " . filesize($xml_file) . " bytes<br>";
    echo "Modified: " . date("Y-m-d H:i:s", filemtime($xml_file)) . "<br>";
} else {
    echo "❌ XML file NOT found!<br>";
}

echo "<hr>";
echo "<h3>Diagnosis:</h3>";
echo "<p>If vQmod is NOT modifying the file, the problem is:</p>";
echo "<ul>";
echo "<li>XML file has syntax error</li>";
echo "<li>vQmod is not finding the search pattern in login.php</li>";
echo "<li>vQmod cache needs to be regenerated</li>";
echo "</ul>";
?>