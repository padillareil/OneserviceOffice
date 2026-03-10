<?php
  require_once "../../../../config/connection.php";

  $SysNum     = $_POST['SysNum'];

try {
  $conn->beginTransaction();

    $downloadAttachment = $conn->prepare("
      SELECT Attachment
      FROM TKT_REQUEST 
      WHERE SysNum = ?
    ");
    $downloadAttachment->execute([ $SysNum ]);
    $get_attachment = $downloadAttachment->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_attachment
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