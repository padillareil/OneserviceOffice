<?php
require_once "../../../../config/connection.php";
require_once "../../../../config/functions.php";
session_start();

$Userid   = $_SESSION['Uid'];
$Password = hash_password($_POST['Password']);

try {
    $conn->beginTransaction();

    $upd_password = $conn->prepare("UPDATE UserAccount SET UserPassword=? WHERE Uid=?");
    $upd_password->execute([$Password,$Userid]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    