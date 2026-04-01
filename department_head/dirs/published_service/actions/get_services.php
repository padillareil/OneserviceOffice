<?php
  require_once "../../../../config/connection.php";
  require_once "../../../../config/functions.php";
  session_start();

  $User     = $_SESSION['Uid'];

  if (!isset($_SESSION['Uid'])) {
      header('Location: ../../../login.php');
      exit();
  }


  $CurrentPage  = $_POST['CurrentPage'] ?? 1;
  $PageSize     = $_POST['PageSize'] ?? 10;
  $Search       = $_POST['Search'] ?? '';
  $Visibility   = $_POST['Visibility'] ?? '';


try {
  $conn->beginTransaction();

    $fetch_services = $conn->prepare("EXEC dbo.[Services_list] ?,?,?,?, ?");
    $fetch_services->execute([$User, $CurrentPage, $PageSize, $Search, $Visibility]);
    $get_srvs = $fetch_services->fetchAll(PDO::FETCH_ASSOC);
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