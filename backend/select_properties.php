<?php
try {
    $limit = 6;
    $message = false;

    if (isset($limitHomePage)):
        $limit = 3;
    endif;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) {
        $page = 1;
    }

    $offset = ($page - 1) * $limit;

    $stmt = $conn->prepare("SELECT COUNT(*) FROM properties");
    $stmt->execute();
    $total_items = $stmt->fetchColumn();

    $total_pages = ceil($total_items / $limit);

    $agent_id = (isset($_GET['agent_id'])) ? $_GET['agent_id'] : 0;
    if ($agent_id > 0) {
        $stmt = $conn->prepare("SELECT * FROM properties WHERE agent_id = :agent_id LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);
    } else {
        $sql = "SELECT * FROM properties LIMIT :limit OFFSET :offset";
        $stmt = $conn->prepare($sql);
    }

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($properties) > 0):
        $message = true;
    endif;
} catch (PDOException $e) {
    $message = "Error fetching properties: " . $e->getMessage();
    exit();
}
