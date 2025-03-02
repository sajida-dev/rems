<?php
require_once "components/db_connection.php";
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    $_SESSION["msg"] = "Invalid or missing property ID.";
    echo "<script>window.location.href = 'all-properties.php';</script>";
    exit;
}

try {
    $conn->beginTransaction();

    $stmtAmenities = $conn->prepare("DELETE FROM property_amenities WHERE property_id = :id");
    $stmtAmenities->bindParam(":id", $id, PDO::PARAM_INT);
    $stmtAmenities->execute();

    $stmtImages = $conn->prepare("DELETE FROM uploads WHERE property_id = :id");
    $stmtImages->bindParam(":id", $id, PDO::PARAM_INT);
    $stmtImages->execute();

    $stmtProperty = $conn->prepare("DELETE FROM properties WHERE id = :id");
    $stmtProperty->bindParam(":id", $id, PDO::PARAM_INT);
    $stmtProperty->execute();

    if ($stmtProperty->rowCount() > 0) {
        $conn->commit();
        $_SESSION["msg"] = "Property and associated data deleted successfully.";
    } else {
        $conn->rollBack();
        $_SESSION["msg"] = "No property found with the provided ID or unable to delete.";
    }
} catch (PDOException $e) {
    $conn->rollBack();
    $_SESSION["msg"] = "Error deleting property: " . $e->getMessage();
}

echo "<script>window.location.href = 'all-properties.php';</script>";
exit;
