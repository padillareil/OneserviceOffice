<?php
  require_once "../../../config/connection.php";
  session_start();

  if (!isset($_SESSION['Uid'])) {
      header('Location: ../../../login.php');
      exit();
  }

  $User     = $_SESSION['Uid'];
  $Req_id   = $_POST['Req_id'];

try {
  $conn->beginTransaction();

    $fetch_details = $conn->prepare("
      SELECT
      Greetings,
      Req_id,
      ServiceCat,
      Urgency,
      Purpose,
      Description,
      Document
      FROM request  
      WHERE Req_id = ? 
    ");
    $fetch_details->execute([ $Req_id ]);
    $get_info = $fetch_details->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_info
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