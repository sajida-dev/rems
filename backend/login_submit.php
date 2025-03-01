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

    // If no errors, attempt login
    if (empty($errors)) {
        try {
            // Prepare a statement to fetch the user by email
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify the password
                if (password_verify($password, $user['password_hash'])) {
                    // Set session variables
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    $_SESSION['msg'] = "Login successful. Welcome back, " . htmlspecialchars($user['name']) . "!";

                    // Redirect based on role
                    if ($user['role'] === 2) {
                        echo "<script>window.location.href = '/rems/dashboard';</script>";
                        exit;
                    } else {
                        echo "<script>window.location.href = 'index.php';</script>";
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
        $msg = '<div class="alert alert-danger"><ul>';
        foreach ($errors as $error) {
            $msg .= '<li>' . htmlspecialchars($error) . '</li>';
        }
        $msg .= '</ul></div>';
    }
}
