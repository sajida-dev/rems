<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $agent_id = isset($_POST['agent_id']) ? $_POST['agent_id'] : null; // For updating, we need the agent_id
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $agency = trim($_POST['agency']);
    $experience = intval($_POST['experience']);
    $bio = trim($_POST['bio']);
    $categories = isset($_POST['categories']) ? $_POST['categories'] : [];

    $errors = [];

    // Validation
    if (empty($name)) {
        $errors[] = "Agent name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
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

    if (empty($errors)) {

        if (!$agent_id) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Email already exists. Please choose another.";
            }
        }
    }

    // Profile picture handling
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

    // If no errors, proceed to insert or update agent data
    if (empty($errors)) {
        try {
            // Start the transaction for atomicity
            $conn->beginTransaction();

            if ($agent_id) {
                // Update agent details
                $sql = "UPDATE users SET name = :name, email = :email, contact = :contact WHERE id = :agent_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':contact', $contact);
                $stmt->bindParam(':agent_id', $agent_id);
                $stmt->execute();



                // Update agent-specific details
                $sqlAgent = "UPDATE agent SET agency = :agency, experience = :experience, bio = :bio WHERE agent_id = :agent_id";
                $stmtAgent = $conn->prepare($sqlAgent);
                $stmtAgent->bindParam(':agency', $agency);
                $stmtAgent->bindParam(':experience', $experience);
                $stmtAgent->bindParam(':bio', $bio);
                $stmtAgent->bindParam(':agent_id', $agent_id);
                $stmtAgent->execute();

                // Update profile picture if uploaded
                if ($profile_pic_path) {
                    $sql = "UPDATE users SET profile_pic = :profile_pic WHERE id = :agent_id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':profile_pic', $profile_pic_path);
                    $stmt->bindParam(':agent_id', $agent_id);
                    $stmt->execute();
                }

                // Remove old specializations
                $stmtDelete = $conn->prepare("DELETE FROM specializations_agent_categories WHERE agent_id = :agent_id");
                $stmtDelete->bindParam(':agent_id', $agent_id);
                $stmtDelete->execute();

                // Insert new categories
                if (!empty($categories)) {
                    foreach ($categories as $category_id) {
                        $stmtCategory = $conn->prepare("INSERT INTO specializations_agent_categories (agent_id, category_id) VALUES (:agent_id, :category_id)");
                        $stmtCategory->bindParam(':agent_id', $agent_id);
                        $stmtCategory->bindParam(':category_id', $category_id);
                        $stmtCategory->execute();
                    }
                }
            } else {
                $role = 2; // assuming 2 is for agent
                $stmt = $conn->prepare("INSERT INTO users (name, email, role, profile_pic, contact, created_at) VALUES (:name, :email, :password_hash, :role, :profile_pic, :contact, NOW())");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':profile_pic', $profile_pic_path);
                $stmt->bindParam(':contact', $contact);
                $stmt->execute();

                $newUserId = $conn->lastInsertId();

                // Insert into agent table
                $stmtAgent = $conn->prepare("INSERT INTO agent (agent_id, agency, experience, bio, created_at) VALUES (:agent_id, :agency, :experience, :bio, NOW())");
                $stmtAgent->bindParam(':agent_id', $newUserId, PDO::PARAM_INT);
                $stmtAgent->bindParam(':agency', $agency);
                $stmtAgent->bindParam(':experience', $experience, PDO::PARAM_INT);
                $stmtAgent->bindParam(':bio', $bio);
                $stmtAgent->execute();

                // Insert categories
                if (!empty($categories)) {
                    foreach ($categories as $category_id) {
                        $stmtCategory = $conn->prepare("INSERT INTO specializations_agent_categories (agent_id, category_id) VALUES (:agent_id, :category_id)");
                        $stmtCategory->bindParam(':agent_id', $newUserId);
                        $stmtCategory->bindParam(':category_id', $category_id);
                        $stmtCategory->execute();
                    }
                }
            }

            // Commit the transaction
            $conn->commit();

            redirect('all-agents.php', "Agent updated successfully.");
        } catch (PDOException $e) {
            $conn->rollBack();
            $_SESSION['error'] = "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = implode('<br>', $errors);
    }
}

try {
    $cat = $conn->prepare("SELECT `id`, `name` FROM `property_categories`;");
    $cat->execute();
    $categories = $cat->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    redirect("update-agent.php", "Database error: " . $e->getMessage(), "error");
}

if (isset($_GET['id'])) {
    $agent_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM users u LEFT JOIN agent a ON u.id = a.agent_id WHERE u.id = :agent_id AND u.role = 2");
    $stmt->bindParam(':agent_id', $agent_id);
    $stmt->execute();
    $agent = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmtAgentCategories = $conn->prepare("SELECT category_id FROM specializations_agent_categories WHERE agent_id = :agent_id");
    $stmtAgentCategories->bindParam(':agent_id', $agent_id);
    $stmtAgentCategories->execute();
    $selectedCategories = $stmtAgentCategories->fetchAll(PDO::FETCH_COLUMN);

    // print_r($agent);
    // exit;
    if (!$agent) {
        redirect("all-agents.php");
    }
} else {
    redirect("all-agents.php");
}
