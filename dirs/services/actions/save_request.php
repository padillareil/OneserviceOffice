<?php
require_once "../../../config/connection.php";
session_start();

if (!isset($_SESSION['Uid'])) {
    exit("Unauthorized");
}

$User        = $_SESSION['Uid'];
$Description = $_POST['Description'] ?? null;
$SrvType     = $_POST['SrvType'] ?? null;
$Department  = $_POST['Department'] ?? null;
$Serviceid   = $_POST['Serviceid'] ?? null;

/* FILE → VARBINARY */
$Attachment = null;

if (!empty($_FILES['attach-file']['tmp_name'])) {

    $Attachment = file_get_contents(
        $_FILES['attach-file']['tmp_name']
    );

    // OPTIONAL: size validation
    if (strlen($Attachment) > 16777215) {
        exit("File too large.");
    }
}

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("CALL SAVE_REQUEST (?,?,?,?,?,?)");
    $stmt->bindParam(1, $User);
    $stmt->bindParam(2, $Description);
    $stmt->bindParam(3, $Attachment, PDO::PARAM_LOB);
    $stmt->bindParam(4, $SrvType);
    $stmt->bindParam(5, $Department);
    $stmt->bindParam(6, $Serviceid);

    $stmt->execute();

    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollBack();
    echo $e->getMessage();
}
