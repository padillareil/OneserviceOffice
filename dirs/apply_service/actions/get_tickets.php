<?php
  require_once "../../../config/connection.php";

  $Srv_id = $_POST['Srv_id'];

try {
  $conn->beginTransaction();

    $fetch_tickets = $conn->prepare("
      SELECT 
      s.RowNum, s.Department, s.ServiceName, s.ServiceType, s.Description, u.UserFullname, u.UserJobPosition
      FROM SRVCS s
      LEFT JOIN UserAccount u ON u.Uid = s.Usr_Posted  
      WHERE RowNum = ?
    ");
    $fetch_tickets->execute([ $Srv_id ]);
    $get_tickets = $fetch_tickets->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_tickets
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