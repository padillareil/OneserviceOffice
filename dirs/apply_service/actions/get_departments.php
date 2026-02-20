<?php
require_once "../../../config/connection.php";
session_start();

if (!isset($_SESSION['Uid'])) {
    header('Location: ../../../login.php');
    exit();
}

$User = $_SESSION['Uid'];

try {
    $conn->beginTransaction();

    $fetch_user = $conn->prepare("EXEC dbo.[SESSION_USERACCOUNT] ?");
    $fetch_user->execute([$User]);
    $get_user = $fetch_user->fetch(PDO::FETCH_ASSOC);

    $fetch_user->closeCursor();

    $Department = $get_user['UserDepartment'];

    $fetch_departments = $conn->prepare("
        SELECT  Department
        FROM SRVCS
        WHERE (Department <> ? OR Department IS NULL)
        GROUP BY Department
        ORDER BY Department DESC
    ");
    $fetch_departments->execute([$Department]);
    $get_dpmnt = $fetch_departments->fetchAll(PDO::FETCH_ASSOC);

    $conn->commit();

    echo json_encode([
        "isSuccess" => "success",
        "Data" => $get_dpmnt
    ]);

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    echo json_encode([
        "isSuccess" => "failed",
        "Data" => "<b>Error. Please contact system developer.</b><br>" . $e->getMessage()
    ]);
}
?>
