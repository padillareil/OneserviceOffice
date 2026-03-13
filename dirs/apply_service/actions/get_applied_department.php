<?php
require_once "../../../config/connection.php";
session_start();

$Userid = $_SESSION['Uid'];

try {

    $conn->beginTransaction();

    $fetch_departments = $conn->prepare("EXEC dbo.[MONITOR_APPLIED_DEPARTMENT] ?");
    $fetch_departments->execute([$Userid]);

    // First result set
    $get_departments = $fetch_departments->fetchAll(PDO::FETCH_ASSOC);

    // Move to second result set
    $fetch_departments->nextRowset();
    $get_teams = $fetch_departments->fetchAll(PDO::FETCH_ASSOC);

    $conn->commit();

    $response = array(
        "isSuccess" => "success",
        "Data" => $get_departments,
        "Teams" => $get_teams
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