<?php
require_once "../../../../config/connection.php";
session_start();

$User               = $_SESSION['Uid'];
$TiketNum           = $_POST['TiketNum'];
$ResponseTicket     = $_POST['ResponseTicket'];
$Status             = $_POST['Status'];

try {
    $conn->beginTransaction();


    $upd_ticket = $conn->prepare("EXEC dbo.[REJECT_TICKET] ?, ? ,? ,?");
    $upd_ticket->execute([$User,$TiketNum,$ResponseTicket,$Status]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    