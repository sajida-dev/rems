<?php

$msg = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
    $username = trim($_POST['username'] ?? '');
    $role     = isset($_POST['role']) ? intval($_POST['role']) : 0;
    $password = trim($_POST['password'] ?? '');

    if (empty($username)) {
        $errors[] = "Username is required.";
    } elseif (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters long.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $errors[] = "Username can only contain letters, numbers, and underscores.";
    }

    $allowedRoles = [1, 2];
    if ($role === 0) {
        $errors[] = "Role is required.";
    } elseif (!in_array($role, $allowedRoles)) {
        $errors[] = "Invalid role selected.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE name = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Username already exists. Please choose another.";
            } else {
                $email = strtolower(str_replace(' ', '', $username)) . '@example.com';
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $contact = '';

                $stmt = $conn->prepare("INSERT INTO users (name, email, role, password_hash, contact, created_at) VALUES (:username, :email, :role, :password_hash, :contact, NOW())");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':password_hash', $passwordHash);
                $stmt->bindParam(':contact', $contact);
                $stmt->execute();

                $newUserId = $conn->lastInsertId();
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['id'] = $newUserId;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;

                $msg = 'Registration successful, welcome' .  htmlspecialchars($username) . '!';
                header("Location: index.php");
                exit;
            }
        } catch (PDOException $e) {
            $errors[] = "An error occurred while processing your request. Please try again later.";
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
