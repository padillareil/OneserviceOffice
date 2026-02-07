<?php
require_once "../../../config/connection.php";
session_start();

if (!isset($_SESSION['Uid'])) {
    exit();
}

$User = $_SESSION['Uid'];
$draft_id = $_POST['draft_id'] ?? '';
$draftDir = "../drafts/user_" . $User;

/* Secure filename */
$filePath = $draftDir . "/" . basename($draft_id);

if (!file_exists($filePath)) {
    echo json_encode([
        "isSuccess" => "error",
        "Data" => "Draft not found"
    ]);
    exit;
}

$content = json_decode(file_get_contents($filePath), true);

echo json_encode([
    "isSuccess" => "success",
    "Data" => $content
]);
?>
