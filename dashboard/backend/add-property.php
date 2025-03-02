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
    $agent_id = intval($_SESSION['id'] ?? 0);

    $errors = [];
    if (empty($title)) $errors[] = "Title is required.";
    if (empty($description)) $errors[] = "Description is required.";
    if ($category_id <= 0) $errors[] = "Please select a valid category.";
    if (empty($location)) $errors[] = "Location is required.";
    if ($rent_price <= 0) $errors[] = "Rent price must be a positive value.";
    if ($bedrooms <= 0) $errors[] = "Please specify the number of bedrooms.";
    if ($bathrooms <= 0) $errors[] = "Please specify the number of bathrooms.";
    if ($area <= 0) $errors[] = "Area must be a positive number.";

    $amenities_selected = $_POST['amenities'] ?? [];
    if (empty($amenities_selected)) {
        $errors[] = "At least one amenity must be selected.";
    }

    // $uploadedFiles = [];
    // if (isset($_FILES['images']) && count($_FILES['images']['name']) > 0) {
    //     for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
    //         if ($_FILES['images']['error'][$i] === 0) {
    //             $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
    //             $fileInfo = pathinfo($_FILES['images']['name'][$i]);
    //             $ext = strtolower($fileInfo['extension']);
    //             if (!in_array($ext, $allowedExts)) {
    //                 $errors[] = "Invalid file type for image: " . $_FILES['images']['name'][$i];
    //             } else {
    //                 $newFileName = uniqid("property_", true) . '.' . $ext;
    //                 $uploadDir = "uploads/properties/";
    //                 if (!is_dir($uploadDir)) {
    //                     mkdir($uploadDir, 0777, true);
    //                 }
    //                 $targetFile = $uploadDir . $newFileName;
    //                 if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $targetFile)) {
    //                     $uploadedFiles[] = $targetFile;
    //                 } else {
    //                     $errors[] = "Failed to upload image: " . $_FILES['images']['name'][$i];
    //                 }
    //             }
    //         } else {
    //             $errors[] = "Error uploading image: " . $_FILES['images']['name'][$i];
    //         }
    //     }
    // } else {
    //     $errors[] = "Main image is required.";
    // }


    $mainImage = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        $fileInfo = pathinfo($_FILES['image']['name']);
        $ext = strtolower($fileInfo['extension']);
        if (!in_array($ext, $allowedExts)) {
            $errors[] = "Invalid file type for main image.";
        } else {
            $newFileName = uniqid("property_", true) . '.' . $ext;
            $uploadDir = "uploads/properties/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $targetFile = $uploadDir . $newFileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $mainImage = $targetFile;
            } else {
                $errors[] = "Failed to upload main image.";
            }
        }
    } else {
        $errors[] = "Main image is required.";
    }

    $galleryFiles = [];
    if (isset($_FILES['gallery']) && count($_FILES['gallery']['name']) > 0 && $_FILES['gallery']['name'][0] != "") {
        for ($i = 0; $i < count($_FILES['gallery']['name']); $i++) {
            if ($_FILES['gallery']['error'][$i] === 0) {
                $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
                $fileInfo = pathinfo($_FILES['gallery']['name'][$i]);
                $ext = strtolower($fileInfo['extension']);
                if (!in_array($ext, $allowedExts)) {
                    $errors[] = "Invalid file type for gallery image: " . $_FILES['gallery']['name'][$i];
                } else {
                    $newFileName = uniqid("gallery_", true) . '.' . $ext;
                    $uploadDir = "uploads/properties/";
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $targetFile = $uploadDir . $newFileName;
                    if (move_uploaded_file($_FILES['gallery']['tmp_name'][$i], $targetFile)) {
                        $galleryFiles[] = $targetFile;
                    } else {
                        $errors[] = "Failed to upload gallery image: " . $_FILES['gallery']['name'][$i];
                    }
                }
            } else {
                $errors[] = "Error uploading gallery image: " . $_FILES['gallery']['name'][$i];
            }
        }
    }


    if (!empty($errors)) {
        $_SESSION['msg'] = implode("<br>", $errors);
        echo "<script>window.location.href = 'new-property.php';</script>";
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
        $stmt->bindParam(':image_url', $mainImage);
        $stmt->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
        $stmt->execute();

        $propertyId = $conn->lastInsertId();

        // $stmtUpload = $conn->prepare("INSERT INTO uploads (property_id, image_url) VALUES (:property_id, :image_url)");
        // foreach ($uploadedFiles as $imgFile) {
        //     $stmtUpload->bindParam(':property_id', $propertyId, PDO::PARAM_INT);
        //     $stmtUpload->bindParam(':image_url', $imgFile);
        //     $stmtUpload->execute();
        // }

        if (!empty($galleryFiles)) {
            $stmtGallery = $conn->prepare("INSERT INTO uploads (property_id, image_url) VALUES (:property_id, :image_url)");
            foreach ($galleryFiles as $imgFile) {
                $stmtGallery->bindParam(':property_id', $propertyId, PDO::PARAM_INT);
                $stmtGallery->bindParam(':image_url', $imgFile);
                $stmtGallery->execute();
            }
        }

        $stmtAmenity = $conn->prepare("INSERT INTO property_amenities (property_id, amenity_id) VALUES (:property_id, :amenity_id)");
        foreach ($amenities_selected as $amenity_id) {
            $stmtAmenity->bindParam(':property_id', $propertyId, PDO::PARAM_INT);
            $stmtAmenity->bindParam(':amenity_id', $amenity_id, PDO::PARAM_INT);
            $stmtAmenity->execute();
        }

        $_SESSION['msg'] = "Property added successfully.";
        echo "<script>window.location.href = 'all-properties.php';</script>";
        exit;
    } catch (PDOException $e) {
        $_SESSION['msg'] = "Database error: " . $e->getMessage();
        echo "<script>window.location.href = 'new-property.php';</script>";
        exit;
    }
endif;


$cat = $conn->prepare("SELECT `id`, `name` FROM `property_categories`;");
$cat->execute();
$categories = $cat->fetchAll(PDO::FETCH_ASSOC);


$stmtAmenity = $conn->query("SELECT * FROM amenities ORDER BY name ASC");
$amenities = $stmtAmenity->fetchAll(PDO::FETCH_ASSOC);
