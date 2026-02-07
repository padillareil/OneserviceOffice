<?php
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
    header("Location: ../login.php");
    exit;
}

session_start();
require_once "../../../../config/connection.php";
require_once "../../../../config/functions.php";

$Userid     = sanitize($_SESSION['Uid']);
$Department = sanitize(strtoupper($_POST['Department']));
$Fullname   = sanitize($_POST['Fullname']);
$Position   = sanitize($_POST['Position']);
$Username   = sanitize($_POST['Username']);
$Password   = hash_password($_POST['Password']);

try {

    $conn->beginTransaction();

    /* Validate username in that department */
    $val_account = $conn->prepare("CALL VAL_USERNAME (?, ?)");
    $val_account->execute([$Department, $Username]);
    $row = $val_account->fetch(PDO::FETCH_ASSOC);
    $val_account->closeCursor();

    if ($row) {
        echo "Team Leader username already exists in this department.";
        exit;
    }

    /* Insert new department + TL user */
    $ins_newdp = $conn->prepare("CALL NEW_DEPARTMENT (?, ?, ?, ?, ?, ?)");
    $ins_newdp->execute([$Department, $Userid, $Username, $Password, $Position, $Fullname]);
    $ins_newdp->closeCursor();

    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollback();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}

?>
