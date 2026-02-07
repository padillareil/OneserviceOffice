<?php
require_once "../../../../config/connection.php";
require_once "../../../../config/functions.php";
session_start();

$User = $_SESSION['Uid'];

if (!isset($_SESSION['Uid'])) {
    header('Location: ../../../../login.php');
    exit();
}

$CurrentPage = $_POST['CurrentPage'];
$PageSize    = $_POST['PageSize'];
$Search      = $_POST['Search'];
$Category    = 'IT';


try {
    $conn->beginTransaction();

    $get_newticket = $conn->prepare("CALL LOADNEW_REQUEST (?,?,?,?)");
    $get_newticket->execute([$CurrentPage, $PageSize, $Search, $Category]);
    $tickets = $get_newticket->fetchAll(PDO::FETCH_ASSOC);
    $get_newticket->closeCursor();


    $conn->commit();

    echo json_encode([
        "isSuccess" => "success",
        "Data" => $tickets
    ]);

} catch (PDOException $e) {
    $conn->rollback();
    echo json_encode([
        "isSuccess" => "Failed",
        "Data" => "<b>Error. Please Contact Software Developer.</b><br>" . $e->getMessage()
    ]);
}
?>
