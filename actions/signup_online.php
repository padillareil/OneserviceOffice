<?php
require_once "../config/connection.php";
require_once "../config/functions.php";

$Username     = $_POST['Username'];
$Password     = hash_password($_POST['Password']);
$Role         = $_POST['Role'];
// $AccountType  =  sanitize($_POST['AccountType']);


try {

    $conn->beginTransaction();

    $ins_acc_online = $conn->prepare("INSERT INTO UserAccount (UserName, UserPassword, Role) VALUES(?,?,?)");
    $ins_acc_online->execute([$Username, $Password, $Role]);

    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollback();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>


