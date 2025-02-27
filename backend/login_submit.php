<?php
$msg = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $name = trim($_POST['name'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($name)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE name = :name LIMIT 1");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password_hash'])) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['name'];
                    $_SESSION['role'] = $user['role'];

                    $_SESSION['success_msg'] = "Login successful. Welcome back, " . htmlspecialchars($user['name']) . "!";
                    header("Location: index.php");
                    exit;
                } else {
                    $errors[] = "Invalid password.";
                }
            } else {
                $errors[] = "User not found.";
            }
        } catch (PDOException $e) {
            $errors[] = "An error occurred. Please try again later.";
        }
    }

    if (!empty($errors)) {
        $msg = '<div class="alert alert-danger"><ul>';
        foreach ($errors as $error) {
            $msg .= '<li>' . htmlspecialchars($error) . '</li>';
        }
        $msg .= '</ul></div>';
    }
}
