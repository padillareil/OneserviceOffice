<?php
require_once "../../../../config/connection.php";
session_start();

$Uid              = $_SESSION['Uid'];
$SysNum           = $_POST['SysNum'];
$ImprtntValue     = $_POST['ImprtntValue'];

try {
    $conn->beginTransaction();


    $upd_important = $conn->prepare("EXEC dbo.[IMPORTANT_TAGGING] ?, ?, ?");
    $upd_important->execute([$Uid,$SysNum,$ImprtntValue]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    