<?php
$id = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;
if ($id <= 0) {
    redirect("login.php", "Invalid user id.", "error");
}


try {
    $sqlUser = "SELECT * FROM users WHERE id = :id";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtUser->execute();
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        redirect("profile.php", "No data found for the current user.", "error");
    }
} catch (PDOException $e) {
    redirect("profile.php", "Database error: " . $e->getMessage(), "error");
}

$user_id = $_SESSION['id'];

// if (isset($_POST['submit'])) {
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $phone = $_POST['phone'];
//     $username = $_POST['username'];
//     $password = $_POST['password'];

//     $profile_pic = $user['profile_pic'];


//     if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
//         $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
//         $fileInfo = pathinfo($_FILES['profile_pic']['name']);
//         $ext = strtolower($fileInfo['extension']);
//         if (!in_array($ext, $allowedExts)) {
//             $errors[] = "Invalid file type for profile picture.";
//         } else {
//             if (!empty($profile_pic) && file_exists($profile_pic)) {
//                 unlink($profile_pic);
//             }

//             $newFileName = uniqid("user_", true) . '.' . $ext;
//             $uploadDir = "dashboard/uploads/avatars/";
//             if (!is_dir($uploadDir)) {
//                 mkdir($uploadDir, 0777, true);
//             }
//             $profile_pic = $uploadDir . $newFileName;
//             if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic)) {
//                 $errors[] = "Failed to upload profile picture.";
//             }
//         }
//     }

//     if (!empty($password)) {
//         $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash password before saving
//     } else {
//         $password_hash = $user['password_hash'];
//     }

//     if (!empty($errors)) {
//         $_SESSION['error'] = implode("<br>", $errors);
//         echo "<script>window.location.href='profile.php'</script>";
//         exit;
//     }


//     // $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, contact = ?, profile_pic = ? WHERE id = ?");
//     // if ($stmt->execute([$name, $email, $phone, $profile_pic, $user_id])) {
//     //     redirect("index.php", "Profile updated successfully.");
//     // } else {
//     //     redirect("profile.php", "Error updating profile.", "error");
//     // }

//     try {
//         $sql = "UPDATE users SET name = :name, email = :email, contact = :contact, username = :username, profile_pic = :profile_pic, password_hash = :password WHERE id = :id";
//         $stmt = $conn->prepare($sql);
//         $stmt->bindParam(':name', $name);
//         $stmt->bindParam(':email', $email);
//         $stmt->bindParam(':contact', $phone);
//         $stmt->bindParam(':username', $username);
//         $stmt->bindParam(':profile_pic', $profile_pic);
//         $stmt->bindParam(':password', $password_hash);
//         $stmt->bindParam(':id', $user_id);

//         if ($stmt->execute()) {
//             redirect("index.php", "Profile updated successfully.");
//         } else {
//             redirect("profile.php", "Error updating profile.", "error");
//         }
//     } catch (PDOException $e) {
//         redirect("profile.php", "Database error: " . $e->getMessage(), "error");
//     }
// }


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $profile_pic = $user['profile_pic'];
    $errors = [];  // Store validation errors

    // Validate name
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    // Validate email (simple email format validation)
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    // Validate phone (ensure it's not empty)
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    }

    // Validate username (ensure it's not empty and check for uniqueness)
    if (empty($username)) {
        $errors[] = "Username is required.";
    } else {
        // Check if the username is already taken by another user
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username AND id != :id");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $errors[] = "Username is already taken.";
        }
    }

    // Handle profile picture upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        $fileInfo = pathinfo($_FILES['profile_pic']['name']);
        $ext = strtolower($fileInfo['extension']);
        if (!in_array($ext, $allowedExts)) {
            $errors[] = "Invalid file type for profile picture.";
        } else {
            // Remove the old profile picture if exists
            if (!empty($profile_pic) && file_exists($profile_pic)) {
                unlink($profile_pic);
            }

            // Generate a new file name and upload
            $newFileName = uniqid("user_", true) . '.' . $ext;
            $uploadDir = "uploads/avatars/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $profile_pic = $uploadDir . $newFileName;
            if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic)) {
                $errors[] = "Failed to upload profile picture.";
            }
        }
    }

    // Hash the password if provided
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Use the existing password hash if no new password
        $password_hash = $user['password_hash'];
    }

    // If there are validation errors, show them and redirect
    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        echo "<script>window.location.href='profile.php'</script>";
        exit;
    }

    // Prepare the SQL query to update the user's profile
    try {
        $sql = "UPDATE users SET name = :name, email = :email, contact = :contact, username = :username, profile_pic = :profile_pic, password_hash = :password WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact', $phone);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':profile_pic', $profile_pic);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':id', $user_id);

        // Execute the update query
        if ($stmt->execute()) {
            redirect("index.php", "Profile updated successfully.");
        } else {
            redirect("profile.php", "Error updating profile.", "error");
        }
    } catch (PDOException $e) {
        redirect("profile.php", "Database error: " . $e->getMessage(), "error");
    }
}
