<?php
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
    header("Location: login.php");
    exit;
}

session_start();
require_once '../config/connection.php';
require_once '../config/functions.php';

$Username = $_POST['Username'];
$Password = $_POST['Password'];

try {
    $stmt = $conn->prepare("EXEC dbo.[LOGIN_ACCOUNT] ?");
    $stmt->execute([$Username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && verify_password($Password, $user['UserPassword'])) {
        $_SESSION['Uid'] = $user['Uid'];
        $_SESSION['Role'] = $user['Role'];
      

        echo json_encode([
            "response" => "OK",
            "role" => $user['Role']
        ]);
    } else {
        echo json_encode([
            "response" => "ERROR",
            "message" => "Invalid username or password"
        ]);
    }

} catch (PDOException $e) {
    echo json_encode([
        "response" => "ERROR",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
?>
