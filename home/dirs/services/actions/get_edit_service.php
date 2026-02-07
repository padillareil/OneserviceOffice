<?php
  require_once "../../../../config/connection.php";
  session_start();

  $User     = $_SESSION['Uid'];

  if (!isset($_SESSION['Uid'])) {
      header('Location: ../../../../login.php');
      exit();
  }


  $Srv_id     = $_POST['Srv_id'];

try {
  $conn->beginTransaction();

    $fetch_services = $conn->prepare("CALL RET_SERVICE (?)");
    $fetch_services->execute([$Srv_id]);
    $get_srvs = $fetch_services->fetch(PDO::FETCH_ASSOC);
    $fetch_services->closeCursor();

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_srvs
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