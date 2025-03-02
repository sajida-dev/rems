<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("Invalid property id.");
}

$stmt = $conn->prepare("
    SELECT p.*, 
           c.name AS category_name,
           GROUP_CONCAT(a.name SEPARATOR ', ') AS amenity_list
    FROM properties p 
    LEFT JOIN property_categories c ON p.category_id = c.id
    LEFT JOIN property_amenities pa ON p.id = pa.property_id
    LEFT JOIN amenities a ON pa.amenity_id = a.id
    WHERE p.id = :id
    GROUP BY p.id
");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$property = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$property) {
    die("Property not found.");
}

// Convert amenity list string to array if needed
$amenityList = [];
if (!empty($property['amenity_list'])) {
    $amenityList = explode(', ', $property['amenity_list']);
}

// Optionally, fetch gallery images separately if you have multiple images stored in uploads table:
$stmtImages = $conn->prepare("SELECT * FROM uploads WHERE property_id = :id");
$stmtImages->bindParam(':id', $id, PDO::PARAM_INT);
$stmtImages->execute();
$galleryImages = $stmtImages->fetchAll(PDO::FETCH_ASSOC);
