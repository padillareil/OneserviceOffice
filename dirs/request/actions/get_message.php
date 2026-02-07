<?php
require_once "../../../config/connection.php";
session_start();

if (!isset($_SESSION['Uid'])) {
    header('Location: ../../../login.php');
    exit();
}

$User = $_SESSION['Uid'];
$Req_id      = $_POST['Req_id'];

try {
    $conn->beginTransaction();

    $get_message = $conn->prepare("CALL GET_MESSAGE (?)");
    $get_message->execute([$Req_id]);
    $users = $get_message->fetch(PDO::FETCH_ASSOC);
    $get_message->closeCursor();
    
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
