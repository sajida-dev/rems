<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $agent_id = intval($_SESSION['id']);
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $agency = trim($_POST['agency'] ?? '');
    $experience = intval($_POST['experience'] ?? 0);

    $specializations = isset($_POST['specializations']) ?  $_POST['specializations'] : [];

    $errors = [];
    if (empty($name)) $errors[] = "Name is required.";

    if (empty($agency)) $errors[] = "Agency name is required.";
    if ($experience < 0) $errors[] = "Experience cannot be negative.";
    if (empty($bio)) $errors[] = "Bio is required.";

    // Process profile picture if provided
    $profile_pic = trim($_POST['current_profile_pic'] ?? '');
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
                $profile_pic = $targetFile;
            } else {
                $errors[] = "Failed to upload profile picture.";
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['msg'] = implode("<br>", $errors);
        echo "<script>window.location.href='update-agent.php?id=" . $agent_id . "'</script>";
        // header("Location: ../update-agent.php?id=" . $agent_id);
        exit;
    }

    try {

        $sql = "UPDATE users
    SET name = :name,  phone = :phone, profile_pic = :profile_pic
    WHERE id = :id AND role = 2";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':profile_pic', $profile_pic);
        $stmt->bindParam(':id', $agent_id, PDO::PARAM_INT);
        $stmt->execute();

        // Update agent table for additional details
        $sqlAgent = "INSERT INTO `agent`( `agent_id`, `agency`, `experience`, `bio`) VALUES (:agent_id,:agency,:experience,:bio)";
        $stmtAgent = $conn->prepare($sqlAgent);
        $stmtAgent->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
        $stmtAgent->bindParam(':agency', $agency);
        $stmtAgent->bindParam(':experience', $experience, PDO::PARAM_INT);
        $stmtAgent->bindParam(':bio', $bio);
        $stmtAgent->execute();

        foreach ($specializations as $spe) {
            $sql = "INSERT INTO `specializations_agent_categories`( `agent_id`, `category_id`) 
            VALUES (:agent_id,:spe)";
            $stmtAgent = $conn->prepare($sql);
            $stmtAgent->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
            $stmtAgent->bindParam(':category_id', $spe, PDO::PARAM_INT);
            $stmtAgent->execute();
        }

        $_SESSION['msg'] = "Agent profile updated successfully.";
        echo "<script>window.location.href='index.php?id=" . $agent_id . "'</script>";
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        echo "<script>window.location.href='profile.php?id=" . $agent_id . "'</script>";
        exit;
    }
}
$agent_id = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;
if ($agent_id <= 0) {
    $_SESSION['msg'] = ("Invalid agent id.");
    echo "<script>window.location.href='../login.php'</script>";
    exit;
}
