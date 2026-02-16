<?php
session_start();
require_once "../config/connection.php";
require_once "../config/functions.php";

$Userid     = $_SESSION['Uid'];
$Theme      = $_POST['Theme'];

try {
    $conn->beginTransaction();

    $upd_theme = $conn->prepare("UPDATE UserAccount SET Theme = ? WHERE Uid = ?");
    $upd_theme->execute([$Theme, $Userid]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    