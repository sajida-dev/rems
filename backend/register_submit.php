<?php
$msg = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = isset($_POST['role']) ? intval($_POST['role']) : 0;
    $password = trim($_POST['password'] ?? '');

    if (empty($name)) {
        $errors[] = "Name is required.";
    } elseif (strlen($name) < 2) {
        $errors[] = "Name must be at least 2 characters long.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    $allowedRoles = [1, 2];
    if ($role === 0) {
        $errors[] = "Role is required.";
    } elseif (!in_array($role, $allowedRoles)) {
        $errors[] = "Invalid role selected.";
    }
    $status = 1;
    if ($role == 1):
        $status = 2;
    endif;


    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Email already exists. Please choose another.";
            } else {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO users (name, email, password_hash, role, status, created_at) VALUES (:name, :email, :password_hash, :role, $status, NOW())");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password_hash', $passwordHash);
                $stmt->bindParam(':role', $role);
                $stmt->execute();

                $newUserId = $conn->lastInsertId();
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['id'] = $newUserId;
                $_SESSION['name'] = $name;
                $_SESSION['role'] = $role;
                $_SESSION['email'] = $email;

                $msg = 'Registration successful, welcome ' . htmlspecialchars($name) . '!';
                if ($role == 2):
                    echo "<script>window.location.href = 'dashboard/profile.php';</script>";
                    exit;
                else:
                    echo "<script>window.location.href = 'index.php';</script>";
                    exit;
                endif;
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
