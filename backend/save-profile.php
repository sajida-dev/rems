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

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $profile_pic = $user['profile_pic'];

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "uploads/avatars/";
        $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
        if ($check !== false) {

            if ($_FILES["profile_pic"]["size"] <= 5000000) {
                if (in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                        $profile_pic = $target_file;
                    } else {
                        $_SESSION['error'] = "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                }
            } else {
                $_SESSION['error'] = "Sorry, your file is too large.";
            }
        } else {
            $_SESSION['error'] = "File is not an image.";
        }
    }

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, contact = ?, profile_pic = ? WHERE id = ?");
    if ($stmt->execute([$name, $email, $phone, $profile_pic, $user_id])) {
        redirect("index.php", "Profile updated successfully.");
    } else {
        redirect("profile.php", "Error updating profile.", "error");
    }
}
