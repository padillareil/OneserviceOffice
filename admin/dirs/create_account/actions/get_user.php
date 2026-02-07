<?php
  require_once "../../../../config/connection.php";

  session_start();

  if (!isset($_SESSION['Uid'])) {
      header('Location: ../../../../login.php');
      exit();
  }

  $User = $_SESSION['Uid'];
  $Uid = $_POST['Uid'];

try {
  $conn->beginTransaction();

    $fetch_user = $conn->prepare("
      SELECT Fullname, Position, Portal_id
      FROM user 
      WHERE Uid = ?
    ");
    $fetch_user->execute([ $Uid ]);
    $get_usr = $fetch_user->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_usr
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

