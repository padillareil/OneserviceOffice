<?php
require_once "../../../../config/connection.php";
session_start();

//  Validate Session
if (!isset($_SESSION['Uid'])) {
    exit("Session Expired");
}

// Sanitize Inputs
$User          = $_SESSION['Uid'];
$ServiceName   = trim($_POST['ServiceName'] ?? '');
$Visibility    = trim($_POST['Visibility'] ?? '');
$ServiceType   = trim($_POST['ServiceType'] ?? '');
$Description   = trim($_POST['Description'] ?? '');

try {
    $conn->beginTransaction();

    // Check duplicate
    $check_duplicate = $conn->prepare("EXEC dbo.[Validate_Duplct_Srvc] ?, ?");
    $check_duplicate->execute([$User, $ServiceName]);

    if ($check_duplicate->fetchColumn() > 0) {
        $conn->rollBack();
        exit("This service already exists.");
    }

    // Generate Service Code
    $postnumber = $conn->prepare("EXEC dbo.[Service_Num_Generator] ?");
    $postnumber->execute([$User]);
    $service_num = $postnumber->fetch(PDO::FETCH_ASSOC);

    $ServiceCode = $service_num['ServiceCode']; // NVARCHAR like VC100000001

    // Insert Service Post
    $ins_servicepost = $conn->prepare("EXEC dbo.[Create_Post_Service] ?,?,?,?,?,?");
    $ins_servicepost->execute([
        $User,
        $ServiceName,
        $Visibility,
        $ServiceType,
        $Description,
        $ServiceCode  // make sure SP expects NVARCHAR, not INT
    ]);

    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>