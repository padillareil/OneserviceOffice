<?php
require_once "../../../../config/connection.php";
session_start();

$User     = $_SESSION['Uid'];

if (!isset($_SESSION['Uid'])) {
    header('Location: ../../../../login.php');
    exit();
}


$Serviceid = $_POST['Serviceid'];
$Status    = $_POST['Status'];

try {
    $conn->beginTransaction();

    /*Validate if Post Status*/
    $fetch_update = $conn->prepare("
        SELECT *
        FROM SRVCS 
        WHERE ServiceStatus = ? AND RowNum =?");
    $fetch_update->execute([$Status, $Serviceid]);
    if ($fetch_update->fetch()) {
        exit('This post is already closed.');
    }


    $upd_servics = $conn->prepare("UPDATE SRVCS SET ServiceStatus = ? WHERE RowNum = ?");
    $upd_servics->execute([$Status,$Serviceid]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
        