<?php
  require_once "../../../../config/connection.php";
  require_once "../../../../config/functions.php";
  session_start();

  $User     = $_SESSION['Uid'];

  if (!isset($_SESSION['Uid'])) {
      header('Location: ../../../../login.php');
      exit();
  }

  $fetch_user = $conn->prepare("EXEC dbo.[SESSION_USERACCOUNT] ? ");
  $fetch_user->execute([$User]);
  $get_user = $fetch_user->fetch(PDO::FETCH_ASSOC);
  $fetch_user->closeCursor();

  $Department   = $get_user['UserDepartment'];
  $CurrentPage  = $_POST['CurrentPage'] ?? 1;
  $PageSize     = $_POST['PageSize'] ?? 100;
  $Search       = $_POST['Search'];


try {
  $conn->beginTransaction();

    $fetch_services = $conn->prepare("EXEC dbo.[STAFF_ACCOUNTS] ?,?,?,?,?");
    $fetch_services->execute([$Department , $User, $CurrentPage,$PageSize,$Search]);
    $get_srvs = $fetch_services->fetchAll(PDO::FETCH_ASSOC);
    $fetch_user->closeCursor();

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