<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=real_estate_db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conMessage = true;
} catch (PDOException $e) {
    $conMessage = "Connection failed: " . $e->getMessage();
}


function redirect($url, $message = null, $key = 'msg')
{
    if ($message !== null) {
        $_SESSION[$key] = $message;
    }
    echo "<script>window.location.href='" . $url . "';</script>";
    exit;
}
