<?php
require_once "../../../../config/connection.php";
session_start();

$User     = $_SESSION['Uid'];

if (!isset($_SESSION['Uid'])) {
    header('Location: ../../../../login.php');
    exit();
}


$Serviceid     = $_POST['Serviceid'];
$Title         = $_POST['Title'];
$Category      = $_POST['Category'];
$Description   = $_POST['Description'];

try {
    $conn->beginTransaction();

    $upd_servics = $conn->prepare("EXEC dbo.[UPDATE_POST_SERVICE] ?,?,?,?");
    $upd_servics->execute([$Serviceid,$Title,$Category,$Description]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
        