<?php
  require_once "../../../config/connection.php";

  $SysNum     = $_POST['SysNum'];

try {
  $conn->beginTransaction();

    $fetch_customer = $conn->prepare("EXEC dbo.[FIND_CUSTOMER_DATA] ?");
    $fetch_customer->execute([ $SysNum]);
    $get_and_find_this_wonderful_person = $fetch_customer->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_and_find_this_wonderful_person
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