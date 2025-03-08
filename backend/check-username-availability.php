<?php
include "../components/db_connection.php";
if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo 'taken';
    } else {
        echo 'available';
    }
} else {
    echo 'Error: No username provided.';
}
