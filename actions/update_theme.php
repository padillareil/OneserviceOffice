<?php
session_start();
require_once "../config/connection.php";
require_once "../config/functions.php";

$Userid     = $_SESSION['Uid'];
$Theme      = sanitize($_POST['Theme']);

try {
    $conn->beginTransaction();

    $upd_theme = $conn->prepare("CALL CHANGE_THEME (?,?)");
    $upd_theme->execute([$Userid,$Theme]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    