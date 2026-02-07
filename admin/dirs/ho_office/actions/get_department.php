<?php
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
    header("Location: ../login.php");
    exit;
}

require_once "../../../../config/connection.php";
require_once "../../../../config/functions.php";


try {
    $conn->beginTransaction();

    $inv_departments = $conn->prepare("CALL HO_DEPARTMENT ()");
    $inv_departments->execute();
    $dp = $inv_departments->fetchAll(PDO::FETCH_ASSOC);
    $inv_departments->closeCursor();

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
