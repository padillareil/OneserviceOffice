<?php
  require_once "../../../config/connection.php";
  require_once "../../../config/functions.php";
  session_start();

  $User     = $_SESSION['Uid'];

  if (!isset($_SESSION['Uid'])) {
      header('Location: ../../../login.php');
      exit();
  }


  $CurrentPage  = $_POST['CurrentPage'] ?? 1;
  $PageSize     = $_POST['PageSize'] ?? 100;
  $Search       = $_POST['Search'] ?? '';
  $Department    = $_POST['Department'] ?? '';



try {
  $conn->beginTransaction();

    $fetch_services = $conn->prepare("EXEC dbo.[AVAILABLE_SERVICES] ?,?,?,?");
    $fetch_services->execute([$Department, $CurrentPage, $PageSize, $Search ]);
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