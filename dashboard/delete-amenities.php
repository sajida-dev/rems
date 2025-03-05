<?php
require_once "components/db_connection.php";
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    $_SESSION["error"] = "Invalid or missing ID.";
}

try {
    $stmt = $conn->prepare("DELETE FROM amenities WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION["msg"] = "Amenities deleted successfully.";
    } else {
        $_SESSION["error"] = "No record found with the provided ID.";
    }
} catch (PDOException $e) {
    $_SESSION["error"] = "Error deleting record: " . $e->getMessage();
}

echo "<script>window.location.href = 'all-amenities.php';</script>";
exit;
