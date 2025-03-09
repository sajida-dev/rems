<?php
$msg = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password_hash'])) {
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['url'] = $user['profile_pic'];

                    $_SESSION['msg'] = "Login successful. Welcome back, " . htmlspecialchars($user['name']) . "!";


                    $role = ['agent', 'admin'];

                    if (in_array($_SESSION['role'], $role)) {
                        echo "<script>window.location.href = 'dashboard/index.php'</script>";
                        exit;
                    } else {
                        if (isset($_GET['page']) && isset($_GET['agent_id'])) {
                            redirect($_GET['page'] . '?agent_id=' . $_GET['agent_id']);
                        }
                        if (isset($_GET['id'])) {
                            redirect('request-property-buy.php?id=' . $_GET['id']);
                        }
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
