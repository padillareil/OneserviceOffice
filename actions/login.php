<?php
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
    header("Location: login.php");
    exit;
}

session_start();
require_once '../config/connection.php';
require_once '../config/functions.php';

$Username = $_POST['Username'] ?? '';
$Password = $_POST['Password'] ?? '';

// -----------------------------
// Get client IP
// -----------------------------
$IP_Address = $_SERVER['REMOTE_ADDR'] ?? '';
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $IP_Address = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $IP_Address = $_SERVER['HTTP_X_FORWARDED_FOR'];
}

// -----------------------------
// Get browser info
// -----------------------------
$Browser = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

// -----------------------------
// Get hostname (optional, works mainly on LAN)
// -----------------------------
$HostName = gethostbyaddr($IP_Address);

// -----------------------------
// Get geolocation from IP
// -----------------------------
$Location = 'Private';
try {
    $geoJson = file_get_contents("http://ip-api.com/json/{$IP_Address}?fields=status,message,country,regionName,city");
    if ($geoJson) {
        $geo = json_decode($geoJson, true);
        if ($geo['status'] === 'success') {
            $Location = trim("{$geo['city']}, {$geo['regionName']}, {$geo['country']}");
        }
    }
} catch (Exception $ex) {
    // fail silently, leave $Location as 'Unknown'
}

// -----------------------------
// Attempt login
// -----------------------------
try {
    $stmt = $conn->prepare("EXEC dbo.[LOGIN_ACCOUNT] ?");
    $stmt->execute([$Username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && verify_password($Password, $user['UserPassword'])) {
        $_SESSION['Uid'] = $user['Uid'];
        $_SESSION['Role'] = $user['Role'];
        $Remarks = 'Success';
        $response = ["response" => "OK", "role" => $user['Role']];
    } else {
        $Remarks = 'Failed';
        $response = ["response" => "ERROR", "message" => "Invalid username or password"];
    }

    // -----------------------------
    // Log user activity
    // -----------------------------
    $Userid = $user['Uid'] ?? 0; // 0 if login failed
    $ins_useractivity = $conn->prepare("EXEC dbo.[SAVE_USERLOGS] ?, ?, ?, ?, ?, ?");
    $ins_useractivity->execute([$Userid, $HostName, $Browser, $Location, $Remarks, $IP_Address]);

    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode([
        "response" => "ERROR",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
?>
