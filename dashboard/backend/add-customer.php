<?php

$errors = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['customerName']) && isset($_POST['customerEmail']) && isset($_POST['customerPassword'])):

        $name = trim($_POST['customerName']);
        $email = trim($_POST['customerEmail']);
        $password = trim($_POST['customerPassword']);
        $contact = trim($_POST['phone'] ?? '');

        if (empty($name)) {
            $errors[] = "Name is required.";
        }
        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }
        if (empty($password)) {
            $errors[] = "Password is required.";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long.";
        }

        if (empty($errors)) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Email already exists. Please choose another.";
            }
        }

        if (empty($errors)) {
            try {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $role = 1;
                $stmt = $conn->prepare("INSERT INTO users (name, email, password_hash, role, contact, created_at) VALUES (:name, :email, :password_hash, :role, :contact, NOW())");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password_hash', $passwordHash);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':contact', $contact);
                $stmt->execute();

                $_SESSION['msg'] = 'Customer added successfully.';
            } catch (PDOException $e) {
                $_SESSION['msg'] = "Database error: " . $e->getMessage();
            }
            echo "<script>window.location.href = 'all-customers.php';</script>";
            exit;
        } else {
            foreach ($errors as $error) {
                $_SESSION['msg'] .= htmlspecialchars($error) . '<br>';
            }
        }
    endif;
}

$stmt = $conn->query("SELECT * FROM users WHERE role = 'end-user' ORDER BY created_at DESC");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
