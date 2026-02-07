<?php
  require_once "../../../config/connection.php";
  require_once "../../../config/functions.php";
  session_start();

  $User     = $_SESSION['Uid'];

  if (!isset($_SESSION['Uid'])) {
      header('Location: ../../../login.php');
      exit();
  }


  $Srv_id  = $_POST['Srv_id'];

try {
  $conn->beginTransaction();

    $fetch_srv_info = $conn->prepare("CALL GET_SRVINFO (?)");
    $fetch_srv_info->execute([$Srv_id]);
    $get_srvs = $fetch_srv_info->fetch(PDO::FETCH_ASSOC);
    $fetch_srv_info->closeCursor();

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