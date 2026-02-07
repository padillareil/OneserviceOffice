<?php
session_start();
require_once "../config/VIAC_ISERVE.php";

$Username    = $_SESSION['Username'];
$Password    = $_POST['Password'];
$AccntSetup     = 'Y';
$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

try {
    $conn->beginTransaction();

    $upd_account = $conn->prepare("UPDATE USRS SET Password=? , AccntSetup = ? WHERE Username=?");
    $upd_account->execute([$hashedPassword,$AccntSetup,$Username]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    