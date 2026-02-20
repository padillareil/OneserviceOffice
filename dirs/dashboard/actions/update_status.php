<?php
require_once "../../../../config/connection.php";
require_once "../../../../config/functions.php";
session_start();

$User     = $_SESSION['Uid'];

if (!isset($_SESSION['Uid'])) {
    header('Location: ../../../../login.php');
    exit();
}

$ReqStatus   = $_POST['ReqStatus'];
$Req_id      = $_POST['Req_id'];

try {
    $conn->beginTransaction();

    $val_update = $conn->prepare("
        SELECT 1
        FROM request 
        WHERE ReqStats = 3 AND Req_id = ? 
        LIMIT 1
    ");
    $val_update->execute([$Req_id]);

    if ($val_update->fetch()) {
        exit('This request already rejected.');
    }

    $upd_status = $conn->prepare("UPDATE request SET ReqStats=? WHERE Req_id=?");
    $upd_status->execute([$ReqStatus,$Req_id]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    