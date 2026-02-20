<?php
  require_once "../../../config/connection.php";
  session_start();
  $User     = $_SESSION['Uid'];

  if (!isset($_SESSION['Uid'])) {
      header('Location: ../../../login.php');
      exit();
  }

  $Department = $_POST['Department'];


try {
  $conn->beginTransaction();

    $fetch_department = $conn->prepare("
      SELECT  Department AS Department FROM SRVCS WHERE Department = ? GROUP BY Department
    ");
    $fetch_department->execute([ $Department ]);
    $get_dp = $fetch_department->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_dp
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