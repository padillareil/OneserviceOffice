<?php
  session_start();
  require_once "../config/VIAC_ISERVE.php";

  $Username     = $_SESSION['Username'];

try {
  $conn->beginTransaction();
    $fetch_access = $conn->prepare("EXEC dbo.[CHECKACCESS_PROCEDURE] ?;");
    $fetch_access->execute([ $Username ]);
    $get_access = $fetch_access->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_access
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

