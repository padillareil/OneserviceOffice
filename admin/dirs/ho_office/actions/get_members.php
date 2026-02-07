<?php
// Ensure AJAX request
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
      strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
    header("Location: ../login.php");
    exit;
}

session_start();
require_once "../../../../config/connection.php";
require_once "../../../../config/functions.php";

// Collect input
$Admin       = $_SESSION['Uid'];
$Dpt_code     = sanitize($_POST['Dpt_code']);
$CurrentPage = isset($_POST['CurrentPage']) ? (int)$_POST['CurrentPage'] : 1;
$Pagesize    = isset($_POST['Pagesize']) ? (int)$_POST['Pagesize'] : 100;

try {
    $conn->beginTransaction();

    // 2️⃣ Fetch paginated members
    $dp_members = $conn->prepare("CALL GET_MEMBERS (?,?,?)");
    $dp_members->execute([$Dpt_code, $CurrentPage, $Pagesize]);
    $dp = $dp_members->fetchAll(PDO::FETCH_ASSOC);
    $dp_members->closeCursor();

    $conn->commit();

    // 3️⃣ Return response
    $response = array(
        "isSuccess" => "success",
        "Data"      => $dp
    );
    echo json_encode($response);

} catch (Exception $e) {
    $conn->rollback();
    $response = array(
        "isSuccess" => "Failed",
        "Data"      => "<b>Error. Please Contact System Developer.<br/></b>" . $e->getMessage()
    );
    echo json_encode($response);
}
?>

