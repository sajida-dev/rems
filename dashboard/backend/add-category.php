<?php
// require_once "components/db_connection.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['categoryName']) && isset($_POST['categoryDescription'])) {
    $categoryName = trim($_POST['categoryName']);
    $categoryDescription = trim($_POST['categoryDescription']);
    $errors = array();

    if (empty($categoryName)) {
        $errors[] = "Category name is required.";
    }
    if (empty($categoryDescription)) {
        $errors[] = "Description is required.";
    }

    if (count($errors) > 0) {
        $_SESSION['error'] = implode("<br>", $errors);
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO property_categories (name, description, created_at) VALUES (:name, :description, NOW())");
            $stmt->bindParam(':name', $categoryName);
            $stmt->bindParam(':description', $categoryDescription);
            $stmt->execute();
            $_SESSION['msg'] = 'Cateogory add successfully.';
            echo "<script>window.location.href = 'all-categories.php';</script>";
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = "Database error: " . $e->getMessage();
            echo "<script>window.location.href = 'all-categories.php';</script>";
            exit;
        }
    }
}

$stmt = $conn->query("SELECT * FROM property_categories ORDER BY created_at DESC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
