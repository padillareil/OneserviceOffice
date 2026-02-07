<?php
  if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
      header("Location: login.php");
      exit;
  }
  session_start();
  require_once "../config/offline_db.php";
  require_once "../config/functions.php";

    $Uid            = $_SESSION['Uid'];
    $Fullname       = sanitize($_POST['Fullname']);
    $Position       = sanitize($_POST['Position']);
    $Password       = hash_password($_POST['Password']);

try {
    $conn->beginTransaction();


    $upd_acc = $conn->prepare("CALL ACCOUNT_SETUP (?,?,?,?)");
    $upd_acc->execute([$Uid,$Fullname,$Position,$Password]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    
