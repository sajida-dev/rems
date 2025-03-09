<?php

require_once "../components/db_connection.php";

if (isset($_GET['id'])) {
    $agent_id = $_GET['id'];
    $status = 1;
} else {
    redirect("../all-agents.php", "Missing parameters", "error");
}

$stmt = $conn->prepare("SELECT email, name FROM users WHERE id = :agent_id AND role = 'agent'");
$stmt->bindParam(':agent_id', $agent_id);
$stmt->execute();

$agent = $stmt->fetch(PDO::FETCH_ASSOC);
$agent_email = "";
$agent_name = "";
if ($agent) {

    $agent_email = $agent['email'];
    $agent_name = $agent['name'];
} else {
    redirect("../../all-agents.php", "Agent not found", "error");
}

$username = generateUniqueUsername($conn, $agent_name, $agent_email);

$password = generateRandomPassword();

require_once '../../vendor/autoload.php';

require_once "../components/config-php-mailer.php";

$mail->setFrom('saadzaib1123@gmail.com', 'Your Company');

// add agent_email -> $agent_email
$mail->addAddress("saadzaib1123@gmail.com", $agent_name);


$mail->isHTML(true);
$mail->Subject = 'Your Account Credentials';

$mail->Body    = "
    <p>Hello, $agent_name,</p>
    <p>Congratulations! Your account has been <strong>approved</strong>.</p>
    <p>We are happy to inform you that your account is now active with the following details:</p>
    <p><strong>Username:</strong> $username</p>
    <p><strong>Password:</strong> $password</p>
    <p>Please login and change your password after your first login.</p>
    <p>Best regards,</p>
    <p>Your Company</p>
";

if (!$mail->send()) {
    redirect("../all-agents.php", "Email send failed", "error");
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$updateStmt = $conn->prepare("UPDATE users SET username = :username, password_hash = :password_hash WHERE id = :agent_id");
$updateStmt->bindParam(':username', $username);
$updateStmt->bindParam(':password_hash', $hashed_password);
$updateStmt->bindParam(':agent_id', $agent_id);

if ($updateStmt->execute()) {
    $updateStatusStmt = $conn->prepare("UPDATE agent SET status = :status WHERE agent_id = :agent_id");
    $updateStatusStmt->bindParam(':status', $status);
    $updateStatusStmt->bindParam(':agent_id', $agent_id);

    if ($updateStatusStmt->execute()) {
        redirect("../all-agents.php", "Agent updated successfully", "success");
    } else {
        redirect("../all-agents.php", "Error updating agent status", "error");
    }
} else {
    redirect("../all-agents.php", "Error updating username and password", "error");
}
// generate username
function generateUniqueUsername($conn, $name, $email)
{
    $baseUsername = strtolower(preg_replace('/\s+/', '', $name));
    $username = $baseUsername;

    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {
        $counter = 1;
        do {
            $username = $baseUsername . $counter;
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $counter++;
        } while ($stmt->fetchColumn() > 0);
    }

    return $username;
}
// generate password
function generateRandomPassword($length = 12)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $password;
}
