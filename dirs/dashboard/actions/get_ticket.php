<?php
  require_once "../../../../config/connection.php";
  require_once "../../../../config/functions.php";
  session_start();

  $User     = $_SESSION['Uid'];

  if (!isset($_SESSION['Uid'])) {
      header('Location: ../../../../login.php');
      exit();
  }

  $Req_id     = $_POST['Req_id'];


try {
  $conn->beginTransaction();

    $fetch_ticket = $conn->prepare("
      SELECT Req_id
      FROM request  
      WHERE Req_id = ?
    ");
    $fetch_ticket->execute([ $Req_id ]);
    $get_ticket = $fetch_ticket->fetch(PDO::FETCH_ASSOC);

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