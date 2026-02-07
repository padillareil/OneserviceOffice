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
$Pin = $_POST['Pin'];

try {
    $conn->beginTransaction();

    $upd_stats = $conn->prepare("UPDATE request SET Pin = ? WHERE Req_id=?");
    $upd_stats->execute([$Pin, $Req_id]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    