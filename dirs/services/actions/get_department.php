<?php
  require_once "../../../config/connection.php";
  session_start();
  $User     = $_SESSION['Uid'];

  if (!isset($_SESSION['Uid'])) {
      header('Location: ../../../login.php');
      exit();
  }

  $Dptmnt = $_POST['Dptmnt'];


try {
  $conn->beginTransaction();

    $fetch_department = $conn->prepare("
      SELECT DISTINCT Dptmnt AS Department FROM services WHERE Dptmnt = ?
    ");
    $fetch_department->execute([ $Dptmnt ]);
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