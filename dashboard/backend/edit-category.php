<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
    $categoryName = trim($_POST["categoryName"]);
    $categoryDescription = trim($_POST["categoryDescription"]);

    $errors = [];
    if (empty($categoryName)) {
        $errors[] = "Category name is required.";
    }
    if (empty($categoryDescription)) {
        $errors[] = "Description is required.";
    }

    if (count($errors) > 0) {
        $_SESSION["error"] = implode("<br>", $errors);
        echo "<script>window.location.href = 'all-categories.php';</script>";
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE property_categories SET name = :name, description = :description WHERE id = :id");
        $stmt->bindParam(":name", $categoryName);
        $stmt->bindParam(":description", $categoryDescription);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION["msg"] = "Category updated successfully.";
    } catch (PDOException $e) {
        $_SESSION["error"] = "Database error: " . $e->getMessage();
    }
    echo "<script>window.location.href = 'all-categories.php';</script>";
    exit;
}
