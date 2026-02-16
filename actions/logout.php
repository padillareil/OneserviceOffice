<?php
require_once "../config/connection.php";
require_once "../config/functions.php";
session_start();

$Userid = $_SESSION['Uid'] ?? 0; // 0 if session expired
$Browser = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

// Get client IP
$IP_Address = $_SERVER['REMOTE_ADDR'] ?? '';
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $IP_Address = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $IP_Address = $_SERVER['HTTP_X_FORWARDED_FOR'];
}

// Attempt hostname (LAN only)
$HostName = gethostbyaddr($IP_Address);

// Geolocation
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
    // ignore errors
}

// Log the logout activity
try {
    if ($Userid > 0) {
        $stmtLog = $conn->prepare("EXEC dbo.[SAVE_USERLOGS] ?, ?, ?, ?, ?, ?");
        $stmtLog->execute([$Userid, $HostName, $Browser, $Location, 'Logout', $IP_Address]);
    }
} catch (PDOException $e) {
    // Optional: log this somewhere else if needed
}

// Destroy session
session_destroy();
echo "OK";
?>
