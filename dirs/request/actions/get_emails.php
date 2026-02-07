<?php
require_once "../../../config/connection.php";
session_start();

if (!isset($_SESSION['Uid'])) {
    header('Location: ../../../login.php');
    exit();
}

$User = $_SESSION['Uid'];
$CurrentPage = $_POST['CurrentPage'] ?? 1;
$PageSize    = $_POST['PageSize'] ?? 100;
$Search      = $_POST['Search'];
$CreatedDate = $_POST['CreatedDate'];
$LastUpdate  = $_POST['LastUpdate'];
$Pin  = $_POST['Pin'] ?? 0;




try {
    $conn->beginTransaction();

    $get_request = $conn->prepare("CALL LOAD_EMAILS (?,?,?,?,?,?, ?)");
    $get_request->execute([$CurrentPage, $PageSize, $Search, $User, $CreatedDate, $LastUpdate, $Pin]);
    $users = $get_request->fetchAll(PDO::FETCH_ASSOC);
    $get_request->closeCursor();
    
    $conn->commit();

    echo json_encode([
        "isSuccess" => "success",
        "Data" => $users
    ]);

} catch (PDOException $e) {
    $conn->rollback();
    echo json_encode([
        "isSuccess" => "Failed",
        "Data" => "<b>Error. Please Contact Software Developer.</b><br>" . $e->getMessage()
    ]);
}
?>
