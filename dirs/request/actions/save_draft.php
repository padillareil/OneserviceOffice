<?php
require_once "../../../config/connection.php";
session_start();

if (!isset($_SESSION['Uid'])) {
    http_response_code(401);
    exit(json_encode(["isSuccess" => false, "message" => "Unauthorized"]));
}

$User = $_SESSION['Uid'];

/* ===== Collect POST ===== */
$Service      = $_POST['Service'] ?? '';
$Urgency      = $_POST['Urgency'] ?? '';
$Greetings   = $_POST['Greetings'] ?? '';
$Purpose      = $_POST['Purpose'] ?? '';
$Description  = $_POST['Description'] ?? '';

if (!$Service || !$Urgency || !$Greetings || !$Purpose) {
    exit(json_encode([
        "isSuccess" => false,
        "message"  => "Required fields missing."
    ]));
}

/* ===== Handle File (Optional) ===== */
$fileMeta = null;

if (!empty($_FILES['suppoting_docs']) && $_FILES['suppoting_docs']['error'] === 0) {

    $allowed = ['image/jpeg','image/png','application/pdf'];
    if (!in_array($_FILES['suppoting_docs']['type'], $allowed)) {
        exit(json_encode([
            "isSuccess" => false,
            "message"  => "Invalid file type."
        ]));
    }

    if ($_FILES['suppoting_docs']['size'] > 15 * 1024 * 1024) {
        exit(json_encode([
            "isSuccess" => false,
            "message"  => "File exceeds 15MB."
        ]));
    }

    // Read file contents directly into memory and convert to base64
    $fileContents = file_get_contents($_FILES['suppoting_docs']['tmp_name']);
    $fileMeta = [
        "name" => $_FILES['suppoting_docs']['name'],
        "type" => $_FILES['suppoting_docs']['type'],
        "size" => $_FILES['suppoting_docs']['size'],
        "data" => base64_encode($fileContents) // store as binary/base64
    ];
}

/* ===== Draft JSON ===== */
$draftID = uniqid("req_", true);

$draftData = [
    "draft_id"   => $draftID,
    "user_id"    => $User,
    "created_at" => date("Y-m-d H:i:s"),
    "request" => [
        "service"     => $Service,
        "urgency"     => $Urgency,
        "greetings"   => $Greetings,
        "purpose"     => $Purpose,
        "description" => $Description,
        "attachment"  => $fileMeta // base64 binary stored here
    ]
];

/* ===== Save Draft JSON ===== */
$baseDir = __DIR__ . "/../drafts/user_" . $User;
if (!is_dir($baseDir)) {
    mkdir($baseDir, 0777, true);
}

file_put_contents(
    $baseDir . "/" . $draftID . ".json",
    json_encode($draftData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
);

/* ===== Response ===== */
echo json_encode([
    "isSuccess" => true,
    "draft_id"  => $draftID
]);
?>