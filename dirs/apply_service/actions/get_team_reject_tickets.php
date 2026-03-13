<?php
  require_once "../../../config/connection.php";
  session_start();

  $User     = $_SESSION['Uid'];

  if (!isset($_SESSION['Uid'])) {
      header('Location: ../../../login.php');
      exit();
  }


  $CurrentPage  = $_POST['CurrentPage'] ?? 1;
  $PageSize     = $_POST['PageSize'] ?? 20;
  $Search       = $_POST['Search'];
  $Department   = $_POST['Department'] ?? '';
  $Staff        = $_POST['Staff'] ?? '';
  $DateFrom     = $_POST['DateFrom']?? '';
  $DateTo       = $_POST['DateTo']?? '';

try {
  $conn->beginTransaction();

    $fetch_clients = $conn->prepare("EXEC dbo.[REJECTED_TICKETS_TEAMS] ?,?,?,?,?,?,?,?");
    $fetch_clients->execute([
        $User,
        $CurrentPage,
        $PageSize,
        $Search,
        $Department,
        $Staff,
        $DateFrom,
        $DateTo
    ]);
    $get_allclients = $fetch_clients->fetchAll(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_allclients
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