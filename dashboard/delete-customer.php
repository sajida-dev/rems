<?php
require_once "components/db_connection.php";
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    $_SESSION["msg"] = "Invalid or missing ID.";
}

try {
    $stmt = $conn->prepare("DELETE FROM property_categories WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION["msg"] = "Category deleted successfully.";
    } else {
        $_SESSION["msg"] = "No record found with the provided ID.";
    }
} catch (PDOException $e) {
    $_SESSION["msg"] = "Error deleting record: " . $e->getMessage();
}

echo "<script>window.location.href = 'all-categories.php';</script>";
exit;
