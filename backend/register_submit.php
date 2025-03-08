<?php
$msg = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = isset($_POST['role']) ? intval($_POST['role']) : 0;

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


    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Email already exists. Please choose another.";
            } else {

                $url = ($role == 2) ? "assets/img/avatar.png" : "images/avatar.png";
                $stmt = $conn->prepare("INSERT INTO users (name, email,  role, profile_pic,  created_at) VALUES (:name, :email,  :role, :url, NOW())");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':url', $url);
                $stmt->execute();

                $newUserId = $conn->lastInsertId();
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                if ($role == 1) {
                    $role = "user";
                } else {
                    $role = "agent";
                }

                $_SESSION['id'] = $newUserId;
                $_SESSION['name'] = $name;
                $_SESSION['role'] = $role;
                $_SESSION['email'] = $email;


                $msg = 'Registration successful, welcome ' . htmlspecialchars($name) . '!';
                if ($role == 'agent'):
                    $_SESSION['url'] = 'assets/img/avatar.png';
                    echo "<script>window.location.href = 'dashboard/profile.php';</script>";
                    exit;
                else:
                    $_SESSION['url'] = 'images/avatar.png';
                    echo "<script>window.location.href = 'profile.php';</script>";
                    exit;
                endif;
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "An error occurred while processing your request. Please try again later.";
        }
    }

    if (!empty($errors)) {
        $msg = '<div class="alert alert-danger">';
        foreach ($errors as $error) {
            $msg .= htmlspecialchars($error) . '<br>';
        }
        $msg .= '</div>';
    }
}
