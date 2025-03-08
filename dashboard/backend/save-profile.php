<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $agent_id = intval($_SESSION['id']);
    $phone = trim($_POST['phone'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $agency = trim($_POST['agency'] ?? '');
    $experience = intval($_POST['experience'] ?? 0);
    $specializations = isset($_POST['specializations']) ? $_POST['specializations'] : [];
    $errors = [];

    if (empty($agency)) $errors[] = "Agency name is required.";
    if ($experience < 0) $errors[] = "Experience cannot be negative.";
    if (empty($bio)) $errors[] = "Bio is required.";

    $profile_pic = trim($_POST['current_profile_pic'] ?? '');
    $newProfilePic = $profile_pic;

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        $fileInfo = pathinfo($_FILES['profile_pic']['name']);
        $ext = strtolower($fileInfo['extension']);
        if (!in_array($ext, $allowedExts)) {
            $errors[] = "Invalid file type for profile picture.";
        } else {
            if (!empty($profile_pic) && file_exists($profile_pic)) {
                unlink($profile_pic);
            }

            $newFileName = uniqid("agent_", true) . '.' . $ext;
            $uploadDir = "uploads/avatars/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $newProfilePic = $uploadDir . $newFileName;
            if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $newProfilePic)) {
                $errors[] = "Failed to upload profile picture.";
            }
        }
    } else {
        $newProfilePic = $_SESSION['url'];
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        echo "<script>window.location.href='profile.php'</script>";
        exit;
    }

    try {


        // Update the user's profile 
        $sql = "UPDATE users
                SET contact = :contact, profile_pic = :profile_pic
                WHERE id = :id AND role = 2";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':contact', $phone);
        $stmt->bindParam(':profile_pic', $newProfilePic);
        $stmt->bindParam(':id', $agent_id, PDO::PARAM_INT);
        $stmt->execute();

        $sqlUser = "SELECT * FROM users WHERE id = :id AND role = 2";
        $stmtUser = $conn->prepare($sqlUser);
        $stmtUser->bindParam(':id', $agent_id, PDO::PARAM_INT);
        $stmtUser->execute();
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        $_SESSION['url'] = $user['profile_pic'];
        $_SESSION['username'] = $user['username'];

        // Check if agent data exists
        $sqlAgent = "SELECT * FROM agent WHERE agent_id = :agent_id";
        $stmtAgent = $conn->prepare($sqlAgent);
        $stmtAgent->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
        $stmtAgent->execute();
        $agent = $stmtAgent->fetch(PDO::FETCH_ASSOC);

        if ($agent) {
            // agent already exists
            $sqlAgentUpdate = "UPDATE agent
                               SET agency = :agency, experience = :experience, bio = :bio
                               WHERE agent_id = :agent_id";
            $stmtAgentUpdate = $conn->prepare($sqlAgentUpdate);
            $stmtAgentUpdate->bindParam(':agency', $agency);
            $stmtAgentUpdate->bindParam(':experience', $experience, PDO::PARAM_INT);
            $stmtAgentUpdate->bindParam(':bio', $bio);
            $stmtAgentUpdate->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
            $stmtAgentUpdate->execute();
        } else {
            // insert agent
            $sqlAgentInsert = "INSERT INTO agent (agent_id, agency, experience, bio)
                               VALUES (:agent_id, :agency, :experience, :bio)";
            $stmtAgentInsert = $conn->prepare($sqlAgentInsert);
            $stmtAgentInsert->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
            $stmtAgentInsert->bindParam(':agency', $agency);
            $stmtAgentInsert->bindParam(':experience', $experience, PDO::PARAM_INT);
            $stmtAgentInsert->bindParam(':bio', $bio);
            $stmtAgentInsert->execute();
        }


        $sqlDeleteSpecializations = "DELETE FROM specializations_agent_categories WHERE agent_id = :agent_id";
        $stmtDeleteSpecializations = $conn->prepare($sqlDeleteSpecializations);
        $stmtDeleteSpecializations->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
        $stmtDeleteSpecializations->execute();

        // Insert new specializations
        foreach ($specializations as $spe) {
            $sqlInsertSpecialization = "INSERT INTO specializations_agent_categories (agent_id, category_id)
                                        VALUES (:agent_id, :category_id)";
            $stmtSpecialization = $conn->prepare($sqlInsertSpecialization);
            $stmtSpecialization->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
            $stmtSpecialization->bindParam(':category_id', $spe, PDO::PARAM_INT);
            $stmtSpecialization->execute();
        }

        $_SESSION['msg'] = "Agent profile updated successfully.";
        echo "<script>window.location.href='index.php'</script>";
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        echo "<script>window.location.href='profile.php'</script>";
        exit;
    }
}

$agent_id = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;
if ($agent_id <= 0) {
    $_SESSION['error'] = "Invalid agent id.";
    echo "<script>window.location.href='../login.php'</script>";
    exit;
}


try {
    $sqlUser = "SELECT * FROM users WHERE id = :id AND role = 2";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bindParam(':id', $agent_id, PDO::PARAM_INT);
    $stmtUser->execute();
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    $sqlAgent = "SELECT * FROM agent WHERE agent_id = :agent_id";
    $stmtAgent = $conn->prepare($sqlAgent);
    $stmtAgent->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
    $stmtAgent->execute();
    $agent = $stmtAgent->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT category_id FROM specializations_agent_categories WHERE agent_id = :agent_id";
    $stmtSpecialization = $conn->prepare($sql);
    $stmtSpecialization->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
    $stmtSpecialization->execute();
    $specializations = $stmtSpecialization->fetchAll(PDO::FETCH_COLUMN, 0);

    if (!$user) {
        $_SESSION['error'] = "No data found for the current agent.";
        echo "<script>window.location.href='profile.php'</script>";
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
    echo "<script>window.location.href='profile.php'</script>";
    exit;
}
