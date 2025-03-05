<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
    $amenitiesName = trim($_POST["amenitiesName"]);
    $amenitiesDescription = trim($_POST["amenitiesDescription"]);

    $errors = [];
    if (empty($amenitiesName)) {
        $errors[] = "Amenities name is required.";
    }
    if (empty($amenitiesDescription)) {
        $errors[] = "Description is required.";
    }

    if (count($errors) > 0) {
        $_SESSION["error_msg"] = implode("<br>", $errors);
        echo "<script>window.location.href = 'all-amenities.php';</script>";
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE amenities SET name = :name, description = :description WHERE id = :id");
        $stmt->bindParam(":name", $amenitiesName);
        $stmt->bindParam(":description", $amenitiesDescription);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION["msg"] = "Amenity updated successfully.";
    } catch (PDOException $e) {
        $_SESSION["error"] = "Database error: " . $e->getMessage();
    }
    echo "<script>window.location.href = 'all-amenities.php';</script>";
    exit;
}
