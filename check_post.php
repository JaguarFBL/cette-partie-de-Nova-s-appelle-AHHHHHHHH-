<?php
// 🔍 SUPER SIMPLE POST CHECKER
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>POST Checker</title>
    <style>
        body { font-family: monospace; background: #1e1e1e; color: #d4d4d4; padding: 20px; }
        .box { background: #252526; padding: 20px; margin: 10px 0; border-radius: 8px; border-left: 4px solid #007acc; }
        .success { border-color: #4ec9b0; }
        .error { border-color: #f48771; }
        pre { background: #1e1e1e; padding: 15px; border-radius: 5px; overflow-x: auto; }
        h2 { color: #4ec9b0; margin-top: 0; }
    </style>
</head>
<body>";
echo "<h1>🔍 POST Data Checker</h1>";

// ✅ Sanitize helper
function h(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? '';

// Méthode de requête — L34 fix: échapper REQUEST_METHOD
echo "<div class='box " . ($requestMethod === 'POST' ? 'success' : 'error') . "'>";
echo "<h2>Méthode de requête</h2>";
echo "<strong>REQUEST_METHOD:</strong> " . h($requestMethod);   // ✅ was unsanitized
echo "</div>";

// Données POST
echo "<div class='box'>";
echo "<h2>📦 \$_POST</h2>";
if (!empty($_POST)) {
    echo "<pre>" . h(print_r($_POST, true)) . "</pre>";
} else {
    echo "<p style='color: #f48771;'>❌ VIDE - Aucune donnée POST reçue</p>";
}
echo "</div>";

// Fichiers uploadés
echo "<div class='box'>";
echo "<h2>📹 \$_FILES</h2>";
if (!empty($_FILES)) {
    echo "<pre>" . h(print_r($_FILES, true)) . "</pre>";
} else {
    echo "<p style='color: #f48771;'>❌ VIDE - Aucun fichier reçu</p>";
}
echo "</div>";

// Content-Type — L44 fix: échapper CONTENT_TYPE et CONTENT_LENGTH
echo "<div class='box'>";
echo "<h2>📋 Headers</h2>";
echo "<strong>CONTENT_TYPE:</strong> " . h($_SERVER['CONTENT_TYPE'] ?? 'Non défini') . "<br>";   // ✅ was unsanitized
echo "<strong>CONTENT_LENGTH:</strong> " . h($_SERVER['CONTENT_LENGTH'] ?? 'Non défini') . " bytes<br>";
echo "</div>";

// Limites PHP
echo "<div class='box'>";
echo "<h2>⚙️ Config PHP</h2>";
echo "<pre>";
echo "upload_max_filesize: " . h(ini_get('upload_max_filesize')) . "\n";
echo "post_max_size: "       . h(ini_get('post_max_size'))       . "\n";
echo "max_execution_time: "  . h(ini_get('max_execution_time'))  . "s\n";
echo "memory_limit: "        . h(ini_get('memory_limit'))        . "\n";
echo "</pre>";
echo "</div>";

// Formulaire de test
echo "<div class='box'>";
echo "<h2>🧪 Formulaire de Test</h2>";
echo '<form method="POST" enctype="multipart/form-data" action="">
    <p><input type="text" name="test_text" placeholder="Teste avec du texte" style="padding: 8px; width: 300px;"></p>
    <p><input type="file" name="test_file"></p>
    <p><button type="submit" style="padding: 10px 20px; background: #007acc; color: white; border: none; border-radius: 5px; cursor: pointer;">📤 Envoyer</button></p>
</form>';
echo "</div>";

// Si POST reçu avec succès
if ($requestMethod === 'POST') {
    echo "<div class='box success'>";
    echo "<h2>✅ POST REÇU AVEC SUCCÈS !</h2>";
    echo "<p>Le formulaire fonctionne correctement.</p>";
    echo "<p><strong>Prochaine étape :</strong> Teste avec une vraie vidéo sur test_form_video.php</p>";
    echo "</div>";
}
echo "</body></html>";
?>
