<?php
require_once "../../../../config/connection.php";
session_start();

$Userid   = $_SESSION['Uid'];
$Landline = $_POST['Landline'];
$Mobile     = $_POST['Mobile'];

try {
    $conn->beginTransaction();

    $stmnt = $conn->prepare("EXEC dbo.[SESSION_USERACCOUNT] ?");
    $stmnt->execute([$Userid]);
    $get_info = $stmnt->fetch(PDO::FETCH_ASSOC);

    $Department =$get_info['UserDepartment'];
    
    $upd_contacts = $conn->prepare("UPDATE UserAccount SET Landline=?, MobileNumber=? WHERE UserDepartment=?");
    $upd_contacts->execute([$Landline, $Mobile, $Department]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    