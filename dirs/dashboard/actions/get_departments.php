<?php
require_once "../../../config/connection.php";
session_start();

$Useri = $_SESSION['Uid'];

try {
    $conn->beginTransaction();

    $fetch_dpclients = $conn->prepare("EXEC dbo.[MYCLIENT_DEPARTMENT] ?");
    $fetch_dpclients->execute([$Useri]);
    $get_dpclintes = $fetch_dpclients->fetchAll(PDO::FETCH_ASSOC);

    $conn->commit();

    $response = array(
        "isSuccess" => "success",
        "Data" => $get_dpclintes
    );
    echo json_encode($response);

} catch (PDOException $e) {
    $conn->rollback();
    $response = array(
        "isSuccess" => "Failed",
        "Data" => "<b>Error. Please Contact System Developer. <br/></b>" . $e->getMessage()
    );
    echo json_encode($response);
}
?>
