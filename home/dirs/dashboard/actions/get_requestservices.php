<?php
  require_once "../../../../config/connection.php";
  session_start();

  $User     = $_SESSION['Uid'];

  if (!isset($_SESSION['Uid'])) {
      header('Location: ../../../../login.php');
      exit();
  }


  $CurrentPage  = $_POST['CurrentPage'] ?? 1;
  $PageSize     = $_POST['PageSize'] ?? 100;
  $Search       = $_POST['Search'];


try {
  $conn->beginTransaction();

    $fetch_requestservice = $conn->prepare("EXEC dbo.[SERVICES_REQUEST] ?,?,?,?");
    $fetch_requestservice->execute([$User , $CurrentPage,$PageSize,$Search]);
    $get_allrequest = $fetch_requestservice->fetchAll(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_allrequest
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