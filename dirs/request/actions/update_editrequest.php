<?php
require_once "../../../config/connection.php";
require_once "../../../config/functions.php";

session_start();

if (!isset($_SESSION['Uid'])) {
    header('Location: ../../../login.php');
    exit();
}

$User = $_SESSION['Uid'];
$Req_id = $_POST['Req_id'];
$Service = $_POST['Service'];
$Purpose = $_POST['Purpose'];
$Urgency = $_POST['Urgency'];
$Greeetings = $_POST['Greeetings'];
$Description = $_POST['Description'];

try {
    $conn->beginTransaction();

    $upd_stats = $conn->prepare("CALL EDIT_REQUEST (?,?,?,?,?,?)");
    $upd_stats->execute([$Req_id, $Service, $Purpose, $Urgency,$Greeetings, $Description]);
    $upd_stats->closeCursor();

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    