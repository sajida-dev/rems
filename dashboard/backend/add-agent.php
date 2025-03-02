<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register_agent'])) {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $contact  = trim($_POST['contact'] ?? '');
    $agency   = trim($_POST['agency'] ?? '');
    $experience = intval($_POST['experience'] ?? 0);
    $bio      = trim($_POST['bio'] ?? '');

    $errors = [];

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
    if (empty($agency)) {
        $errors[] = "Agency name is required.";
    }
    if ($experience < 0) {
        $errors[] = "Experience must be a non-negative number.";
    }
    if (empty($bio)) {
        $errors[] = "Bio is required.";
    }

    // Check if email already exists
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            $errors[] = "Email already exists. Please choose another.";
        }
    }

    // Process optional profile picture upload
    $profile_pic_path = null;
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        $fileInfo = pathinfo($_FILES['profile_pic']['name']);
        $ext = strtolower($fileInfo['extension']);
        if (!in_array($ext, $allowedExts)) {
            $errors[] = "Invalid file type for profile picture.";
        } else {
            $newFileName = uniqid("agent_", true) . '.' . $ext;
            $uploadDir = "uploads/avatars/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $targetFile = $uploadDir . $newFileName;
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
                $profile_pic_path = $targetFile;
            } else {
                $errors[] = "Failed to upload profile picture.";
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        echo "<script>window.location.href = 'register-agent.php';</script>";
        exit;
    }

    try {
        // Insert into users table
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $role = 2;
        $stmt = $conn->prepare("INSERT INTO users (name, email, password_hash, role, profile_pic, contact, created_at) 
                                VALUES (:name, :email, :password_hash, :role, :profile_pic, :contact, NOW())");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $passwordHash);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':profile_pic', $profile_pic_path);
        $stmt->bindParam(':contact', $contact);
        $stmt->execute();

        $newUserId = $conn->lastInsertId();

        // Insert additional agent info into agent table
        $stmtAgent = $conn->prepare("INSERT INTO agent (agent_id, agency, experience, bio, created_at) 
                                     VALUES (:agent_id, :agency, :experience, :bio, NOW())");
        $stmtAgent->bindParam(':agent_id', $newUserId, PDO::PARAM_INT);
        $stmtAgent->bindParam(':agency', $agency);
        $stmtAgent->bindParam(':experience', $experience, PDO::PARAM_INT);
        $stmtAgent->bindParam(':bio', $bio);
        $stmtAgent->execute();

        $_SESSION['msg'] = "Agent registered successfully.";
        echo "<script>window.location.href = 'dashboard/profile.php';</script>";
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        echo "<script>window.location.href = 'register-agent.php';</script>";
        exit;
    }
}


try {
    $stmt = $conn->prepare("
        SELECT u.id, u.name, u.email, u.contact, u.profile_pic, u.created_at,
               a.agency, a.experience, a.bio
        FROM users u
        LEFT JOIN agent a ON u.id = a.agent_id
        WHERE u.role = 2
        ORDER BY u.created_at DESC
    ");
    $stmt->execute();
    $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
