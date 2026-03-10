<?php
require_once "../../../config/connection.php";
session_start();

$User = $_SESSION['Uid'];

$Ticket   = $_POST['Ticket'];
$Comment  = $_POST['Comment'] ?? '';
$Action   = $_POST['Action'];

try {
    $conn->beginTransaction();
   
    $upd_ticket = $conn->prepare("EXEC dbo.[TICKET_ACTIONS] ?, ? ,? ,?");
    $upd_ticket->execute([$User,$Ticket,$Action,$Comment]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    
