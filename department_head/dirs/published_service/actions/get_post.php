<?php
  require_once "../../../../config/connection.php";

  $ServiceId = $_POST['ServiceId'];
  
  try {
    $conn->beginTransaction();

      $fetch_srvInfo = $conn->prepare("EXEC dbo.[Service_Details] ?");
      $fetch_srvInfo->execute([ $ServiceId ]);
      $get_details = $fetch_srvInfo->fetch(PDO::FETCH_ASSOC);

    $conn->commit();

    $response = array(
      "isSuccess" => 'success',
      "Data" => $get_details
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