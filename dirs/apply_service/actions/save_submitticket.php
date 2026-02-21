<?php
require_once "../../../config/connection.php";
session_start();

$Userid       = $_SESSION['Uid'];
$Description  = strip_tags($_POST['Description']); // keep HTML if needed
$TicketNumber = $_POST['TicketNumber'];

try {
    $conn->beginTransaction();

    $Attachment = null;

    // Only 1 file allowed
    if (!empty($_FILES['ticket-attachment']['tmp_name']) && $_FILES['ticket-attachment']['error'] === 0) {
        $tmpPath = $_FILES['ticket-attachment']['tmp_name'];
        $Attachment = file_get_contents($tmpPath); // raw binary
    }

    // Execute stored procedure with VARBINARY param
    $ins_ticket = $conn->prepare("EXEC dbo.[SUBMIT_TICKET_APPLICATION] ?, ?, ?, ?");
    $ins_ticket->bindParam(1, $Userid, PDO::PARAM_INT);
    $ins_ticket->bindParam(2, $Description, PDO::PARAM_STR);
    $ins_ticket->bindParam(3, $Attachment, PDO::PARAM_LOB); // raw binary
    $ins_ticket->bindParam(4, $TicketNumber, PDO::PARAM_STR);

    $ins_ticket->execute();
    $conn->commit();

    echo "OK";

} catch (PDOException $e) {
    $conn->rollback();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>