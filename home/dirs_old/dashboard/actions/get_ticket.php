<?php
  require_once "../../../../config/connection.php";
  session_start();

  $Uid = $_SESSION['Uid'];

try {
  $conn->beginTransaction();

    $fetch_ticketcontent = $conn->prepare("EXEC dbo.[DEPARTMENT_TICKET] ?");
    $fetch_ticketcontent->execute([ $Uid ]);
    $get_ticket = $fetch_ticketcontent->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_ticket
  );
  echo json_encode($response);

}catch (PDOException $e){
  $conn->rollback();
  $response = array(
    "isSuccess" => 'Failed',
    "Data" => "<b>Error. Please Contact System Developer. <br/></b>".$e->getMessage()
  );
  echo json_encode($response);
}
?>