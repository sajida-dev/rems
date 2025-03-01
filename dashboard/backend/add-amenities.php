<?php
// require_once "components/db_connection.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['amenitiesName']) && isset($_POST['amenitiesDescription'])) {
    $amenitiesName = trim($_POST['amenitiesName']);
    $amenitiesDescription = trim($_POST['amenitiesDescription']);
    $errors = array();

    if (empty($amenitiesName)) {
        $errors[] = "Amenities name is required.";
    }
    if (empty($amenitiesDescription)) {
        $errors[] = "Description is required.";
    }

    if (count($errors) > 0) {
        $_SESSION['error_msg'] = implode("<br>", $errors);
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO amenities (name, description, created_at) VALUES (:name, :description, NOW())");
            $stmt->bindParam(':name', $amenitiesName);
            $stmt->bindParam(':description', $amenitiesDescription);
            $stmt->execute();
            $_SESSION['msg'] = 'Amenities add successfully.';
            echo "<script>window.location.href = 'all-amenities.php';</script>";
            exit;
        } catch (PDOException $e) {
            $_SESSION['msg'] = "Database error: " . $e->getMessage();
            echo "<script>window.location.href = 'all-amenities.php';</script>";
            exit;
        }
    }
}

$stmt = $conn->query("SELECT * FROM amenities ORDER BY created_at DESC");
$amenities = $stmt->fetchAll(PDO::FETCH_ASSOC);
