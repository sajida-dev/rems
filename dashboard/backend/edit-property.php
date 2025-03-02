<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['property_id'])) {

    if (is_array($_POST['delete_images'])) {
        require_once "backend/delete-property-images.php";
        exit;
    }

    $propertyId  = intval($_POST['property_id']);
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category_id = intval($_POST['category_id'] ?? 0);
    $location    = trim($_POST['location'] ?? '');
    $rent_price  = floatval($_POST['rent_price'] ?? 0);
    $old_price   = floatval($_POST['old_price'] ?? 0);
    $bedrooms    = intval($_POST['bedrooms'] ?? 0);
    $bathrooms   = intval($_POST['bathrooms'] ?? 0);
    $area        = intval($_POST['area'] ?? 0);

    $errors = [];
    if (empty($title)) $errors[] = "Title is required.";
    if (empty($description)) $errors[] = "Description is required.";
    if ($category_id <= 0) $errors[] = "Please select a valid category.";
    if (empty($location)) $errors[] = "Location is required.";
    if ($rent_price <= 0) $errors[] = "Rent price must be a positive value.";
    if ($bedrooms <= 0) $errors[] = "Please specify the number of bedrooms.";
    if ($bathrooms <= 0) $errors[] = "Please specify the number of bathrooms.";
    if ($area <= 0) $errors[] = "Area must be a positive number.";

    $newMainImage = null;
    $uploadedFiles = [];

    if (isset($_FILES['images']) && count($_FILES['images']['name']) > 0 && $_FILES['images']['name'][0] != "") {
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
                        if ($newMainImage === null) {
                            $newMainImage = $targetFile;
                        }
                    } else {
                        $errors[] = "Failed to upload image: " . $_FILES['images']['name'][$i];
                    }
                }
            } else {
                $errors[] = "Error uploading file: " . $_FILES['images']['name'][$i];
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        echo "<script>window.location.href = 'edit-property.php?id={$propertyId}';</script>";
        exit;
    }

    try {
        if ($newMainImage !== null) {
            $sql = "UPDATE properties 
                    SET category_id = :category_id,
                        title = :title,
                        description = :description,
                        location = :location,
                        rent_price = :rent_price,
                        old_price = :old_price,
                        bedrooms = :bedrooms,
                        bathrooms = :bathrooms,
                        area = :area,
                        image_url = :image_url
                    WHERE id = :id";
        } else {
            $sql = "UPDATE properties 
                    SET category_id = :category_id,
                        title = :title,
                        description = :description,
                        location = :location,
                        rent_price = :rent_price,
                        old_price = :old_price,
                        bedrooms = :bedrooms,
                        bathrooms = :bathrooms,
                        area = :area
                    WHERE id = :id";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':rent_price', $rent_price);
        $stmt->bindParam(':old_price', $old_price);
        $stmt->bindParam(':bedrooms', $bedrooms, PDO::PARAM_INT);
        $stmt->bindParam(':bathrooms', $bathrooms, PDO::PARAM_INT);
        $stmt->bindParam(':area', $area, PDO::PARAM_INT);
        if ($newMainImage !== null) {
            $stmt->bindParam(':image_url', $newMainImage);
        }
        $stmt->bindParam(':id', $propertyId, PDO::PARAM_INT);
        $stmt->execute();

        if (!empty($uploadedFiles)) {
            $stmtUpload = $conn->prepare("INSERT INTO uploads (property_id, image_url) VALUES (:property_id, :image_url)");
            foreach ($uploadedFiles as $imgFile) {
                $stmtUpload->bindParam(':property_id', $propertyId, PDO::PARAM_INT);
                $stmtUpload->bindParam(':image_url', $imgFile);
                $stmtUpload->execute();
            }
        }

        $_SESSION['msg'] = "Property updated successfully.";
        echo "<script>window.location.href = 'all-properties.php';</script>";
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        echo "<script>window.location.href = 'edit-property.php?id={$propertyId}';</script>";
        exit;
    }
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("Invalid property id.");
}

$stmt = $conn->prepare("SELECT * FROM properties WHERE id = :id");
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$property = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$property) {
    die("Property not found.");
}

$stmtCat = $conn->query("SELECT id, name FROM property_categories ORDER BY name ASC");
$categories = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

$stmtImages = $conn->prepare("SELECT * FROM uploads WHERE property_id = :id");
$stmtImages->bindParam(":id", $id, PDO::PARAM_INT);
$stmtImages->execute();
$images = $stmtImages->fetchAll(PDO::FETCH_ASSOC);


$stmtAmenity = $conn->query("SELECT * FROM amenities  ORDER BY name ASC");
$amenities = $stmtAmenity->fetchAll(PDO::FETCH_ASSOC);


$stmtSelectedAmenities = $conn->prepare("SELECT amenity_id FROM property_amenities WHERE property_id = :property_id");
$stmtSelectedAmenities->bindParam(':property_id', $property_id, PDO::PARAM_INT);
$stmtSelectedAmenities->execute();
$selectedAmenities = $stmtSelectedAmenities->fetchAll(PDO::FETCH_ASSOC);
$selectedAmenitiesIds = array_column($selectedAmenities, 'amenity_id');
