<?php

if (!isset($_SESSION['id']) || $_SESSION['role'] != 2) {
    $_SESSION['msg'] = "You must be logged in as an agent to add a property.";
    echo "<script>window.location.href = '../login.php';</script>";
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST"):
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category_id = intval($_POST['category_id'] ?? 0);
    $location = trim($_POST['location'] ?? '');
    $rent_price = floatval($_POST['rent_price'] ?? 0);
    $old_price = floatval($_POST['old_price'] ?? 0);
    $bedrooms = intval($_POST['bedrooms'] ?? 0);
    $bathrooms = intval($_POST['bathrooms'] ?? 0);
    $area = intval($_POST['area'] ?? 0);
    $agent_id = intval($_POST['agent_id'] ?? 0);

    // Validate required fields (add more if needed)
    $errors = [];
    if (empty($title)) $errors[] = "Title is required.";
    if (empty($description)) $errors[] = "Description is required.";
    if ($category_id <= 0) $errors[] = "Please select a valid category.";
    if (empty($location)) $errors[] = "Location is required.";
    if ($rent_price <= 0) $errors[] = "Rent price must be a positive value.";
    if ($bedrooms <= 0) $errors[] = "Please specify the number of bedrooms.";
    if ($bathrooms <= 0) $errors[] = "Please specify the number of bathrooms.";
    if ($area <= 0) $errors[] = "Area must be a positive number.";

    $uploadedFiles = [];
    if (isset($_FILES['images']) && count($_FILES['images']['name']) > 0) {
        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
            if ($_FILES['images']['error'][$i] === 0) {
                $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
                $fileInfo = pathinfo($_FILES['images']['name'][$i]);
                $ext = strtolower($fileInfo['extension']);
                if (!in_array($ext, $allowedExts)) {
                    $errors[] = "Invalid file type for image: " . $_FILES['images']['name'][$i];
                } else {
                    $newFileName = uniqid("property_", true) . '.' . $ext;
                    $uploadDir = "uploads/properties/";
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $targetFile = $uploadDir . $newFileName;
                    if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $targetFile)) {
                        $uploadedFiles[] = $targetFile;
                    } else {
                        $errors[] = "Failed to upload image: " . $_FILES['images']['name'][$i];
                    }
                }
            } else {
                $errors[] = "Error uploading image: " . $_FILES['images']['name'][$i];
            }
        }
    } else {
        $errors[] = "Main image is required.";
    }

    if (!empty($errors)) {
        $_SESSION['msg'] = implode("<br>", $errors);
        echo "<script>window.location.href = 'add-property.php';</script>";
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO properties (category_id, title, description, location, rent_price, old_price, bedrooms, bathrooms, area, image_url, agent_id, created_at) VALUES (:category_id, :title, :description, :location, :rent_price, :old_price, :bedrooms, :bathrooms, :area, :image_url, :agent_id, NOW())");
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':rent_price', $rent_price);
        $stmt->bindParam(':old_price', $old_price);
        $stmt->bindParam(':bedrooms', $bedrooms, PDO::PARAM_INT);
        $stmt->bindParam(':bathrooms', $bathrooms, PDO::PARAM_INT);
        $stmt->bindParam(':area', $area, PDO::PARAM_INT);
        $stmt->bindParam(':image_url', $image_url);
        $stmt->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
        $stmt->execute();

        $propertyId = $conn->lastInsertId();

        $stmtUpload = $conn->prepare("INSERT INTO uploads (property_id, image_url) VALUES (:property_id, :image_url)");
        foreach ($uploadedFiles as $imgFile) {
            $stmtUpload->bindParam(':property_id', $propertyId, PDO::PARAM_INT);
            $stmtUpload->bindParam(':image_url', $imgFile);
            $stmtUpload->execute();
        }

        $_SESSION['msg'] = "Property added successfully.";
        echo "<script>window.location.href = 'all-properties.php';</script>";
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        echo "<script>window.location.href = 'add-property.php';</script>";
        exit;
    }
endif;
$stmt = $conn->prepare("
    SELECT p.id, p.title, p.location, p.rent_price, u.name AS agent_name
    FROM properties p
    LEFT JOIN users u ON p.agent_id = u.id
    ORDER BY p.created_at DESC
");
$stmt->execute();
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
