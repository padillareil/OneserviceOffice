<?php
require_once "../../../config/connection.php";
session_start();

if (!isset($_SESSION['Uid'])) {
    header('Location: ../../../login.php');
    exit();
}

$User = $_SESSION['Uid'];
$draftDir = "../drafts/user_" . $User;

$drafts = [];

if (is_dir($draftDir)) {
    foreach (glob($draftDir . "/*.json") as $file) {
        $content = json_decode(file_get_contents($file), true);

        $drafts[] = [
            "file"       => basename($file),
            "request"    => $content['request'] ?? [],
            "created_at" => $content['created_at'] ?? ''
        ];
    }
}

echo json_encode([
    "isSuccess" => "success",
    "Data"      => $drafts
]);
?>
