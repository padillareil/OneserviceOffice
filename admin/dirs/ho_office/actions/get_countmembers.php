<?php
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
    header("Location: ../login.php");
    exit;
}

require_once "../../../../config/connection.php";
require_once "../../../../config/functions.php";

$Dpt_code = sanitize($_POST['Dpt_code']);
try {
    $conn->beginTransaction();

    $teamleader = $conn->prepare("CALL COUNT_MEMBERS (?)");
    $teamleader->execute([$Dpt_code]);
    $dp = $teamleader->fetch(PDO::FETCH_ASSOC);
    $teamleader->closeCursor();

    $conn->commit();

    $response = array(
        "isSuccess" => "success",
        "Data" => $dp 
    );
    echo json_encode($response);

} catch (PDOException $e) {
    $conn->rollback();
    $response = array(
        "isSuccess" => "Failed",
        "Data" => "<b>Error. Please Contact System Developer.<br/></b>" . $e->getMessage()
    );
    echo json_encode($response);
}
?>
