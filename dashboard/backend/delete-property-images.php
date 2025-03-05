<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
    $imageIds = $_POST['delete_images'];

    $propertyId = intval($_POST['property_id'] ?? 0);

    $imageIds = array_map('intval', $imageIds);

    $placeholders = implode(',', array_fill(0, count($imageIds), '?'));

    $stmt = $conn->prepare("SELECT id, image_url FROM uploads WHERE id IN ($placeholders)");
    $stmt->execute($imageIds);
    $imagesToDelete = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($imagesToDelete as $img) {
        if (file_exists($img['image_url'])) {
            unlink($img['image_url']);
        }
    }

    $stmtDelete = $conn->prepare("DELETE FROM uploads WHERE id IN ($placeholders)");
    $stmtDelete->execute($imageIds);

    $_SESSION['msg'] = "Selected images deleted successfully.";
    echo "<script>window.location.href = 'update-property.php?id=" . $propertyId . "';</script>";
    exit;
} else {
    $_SESSION['error'] = "No images selected for deletion.";
    $propertyId = isset($_POST['property_id']) ? intval($_POST['property_id']) : 0;
    echo "<script>window.location.href = 'update-property.php?id=" . $propertyId . "';</script>";
    exit;
}
