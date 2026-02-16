<?php
  require_once "../../../../config/connection.php";
  session_start();

  $Userid     = $_SESSION['Uid'];

try {
  $conn->beginTransaction();

    $fetch_accountdetails = $conn->prepare("EXEC dbo.[SESSION_USERACCOUNT] ?");
    $fetch_accountdetails->execute([$Userid]);
    $get_info = $fetch_accountdetails->fetch(PDO::FETCH_ASSOC);

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