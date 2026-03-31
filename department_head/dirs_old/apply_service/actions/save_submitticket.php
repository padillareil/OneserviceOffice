<?php
require_once "../../../../config/connection.php";
session_start();

$Userid       = $_SESSION['Uid'];
$Description  = $_POST['Description']; // keep HTML if needed
$TicketNumber = $_POST['TicketNumber'];
$Attachment = isset($_FILES['Attachment']) 
? base64_encode(file_get_contents($_FILES['Attachment']['tmp_name'])) 
: null;



try {
    $conn->beginTransaction();

    // Execute stored procedure with VARBINARY param
    $ins_ticket = $conn->prepare("EXEC dbo.[SUBMIT_TICKET_APPLICATION] ?, ?, ?, ?");
    $ins_ticket->execute([$Userid, $Description, $Attachment, $TicketNumber]);
    $conn->commit();

    echo "OK";

} catch (PDOException $e) {
    $conn->rollback();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>