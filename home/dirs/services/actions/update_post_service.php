<?php
require_once "../../../../config/connection.php";
session_start();

$User     = $_SESSION['Uid'];

if (!isset($_SESSION['Uid'])) {
    header('Location: ../../../../login.php');
    exit();
}


$Id             = $_POST['Id'];
$Service        = $_POST['Service'];
$Type           = $_POST['Type'];
$Availability   = $_POST['Availability'];
$Start          = $_POST['Start'];
$End            = $_POST['End'];
$Description    = $_POST['Description'];

try {
    $conn->beginTransaction();

    $upd_servics = $conn->prepare("CALL UPDATE_POST_SERVICE (?,?,?,?,?,?,?)");
    $upd_servics->execute([$Id,$Service,$Type,$Availability,$Start, $End, $Description]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    