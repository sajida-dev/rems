<?php
$msg = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    // Retrieve form values
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validate email and password
    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password_hash'])) {
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    $_SESSION['msg'] = "Login successful. Welcome back, " . htmlspecialchars($user['name']) . "!";

                    // Redirect based on role
                    $role = ['2', '3', 'agent', 'admin'];

                    if (in_array($_SESSION['role'], $role)) {
                        echo "<script>window.location.href = 'dashboard/index.php'</script>";
                        exit;
                    } else {
                        echo "<script>window.location.href = 'index.php'</script>";
                        exit;
                    }
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
        $msg = '<div class="alert alert-danger animate__animated animate__fadeInDown">';
        foreach ($errors as $error) {
            $msg .=  htmlspecialchars($error) . '<br>';
        }
        $msg .= '</div>';
    }
}
