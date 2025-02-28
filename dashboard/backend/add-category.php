<?php



if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    ob_start();

    header('Content-Type: application/json');

    $response = array('success' => false);


    require_once "components/db_connection.php";

    $categoryName = isset($_POST['categoryName']) ? trim($_POST['categoryName']) : '';
    $categoryDescription = isset($_POST['categoryDescription']) ? trim($_POST['categoryDescription']) : '';

    $errors = array();
    if (empty($categoryName)) {
        $errors[] = "Category name is required.";
    }
    if (empty($categoryDescription)) {
        $errors[] = "Description is required.";
    }

    if (count($errors) > 0) {
        $response['error'] = implode(" ", $errors);
        echo json_encode($response);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO property_categories (name, description, created_at) VALUES (:name, :description, NOW())");
        $stmt->bindParam(':name', $categoryName);
        $stmt->bindParam(':description', $categoryDescription);
        $stmt->execute();

        $newId = $pdo->lastInsertId();

        $response['success'] = true;
        $response['data'] = array(
            'id' => $newId,
            'name' => htmlspecialchars($categoryName),
            'description' => htmlspecialchars($categoryDescription)
        );
    } catch (PDOException $e) {
        $response['error'] = "Database error: " . $e->getMessage();
    }

    echo json_encode($response);
    ob_end_clean();

endif;
