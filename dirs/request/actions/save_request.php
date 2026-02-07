<?php
require_once "../../../config/connection.php";
require_once "../../../config/functions.php";

session_start();

if (!isset($_SESSION['Uid'])) {
    header('Location: ../../../login.php');
    exit();
}

$User        = $_SESSION['Uid'];
$Service     = $_POST['Service'];
$Urgency     = $_POST['Urgency'];
$Greeetings     = $_POST['Greeetings'];
$Purpose     = $_POST['Purpose'];
$Description = $_POST['Description'];

$Branch = 'SHOWROOM';//SAMPLE ONLY

$Document = null;

if (!empty($_FILES['Document']['tmp_name'])) {

    if ($_FILES['Document']['error'] !== UPLOAD_ERR_OK) {
        exit('Upload failed.');
    }

    if ($_FILES['Document']['size'] > 15 * 1024 * 1024) {
        exit('File exceeds size limit.');
    }

    $Document = file_get_contents($_FILES['Document']['tmp_name']);
}

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("CALL ADD_REQUEST (?,?,?,?,?,?,?,?)");
    $stmt->bindParam(1, $Service);
    $stmt->bindParam(2, $Urgency);
    $stmt->bindParam(3, $Purpose);
    $stmt->bindParam(4, $Description);
    $stmt->bindParam(5, $Document, PDO::PARAM_LOB);
    $stmt->bindParam(6, $User);
    $stmt->bindParam(7, $Greeetings);
    $stmt->bindParam(8, $Branch);

    $stmt->execute();

    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollback();
    echo "<b>Warning.</b> Please contact system developer.<br>" . $e->getMessage();
}
