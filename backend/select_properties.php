<?php
try {
    $limit = 6;
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

    $stmt = $conn->prepare("SELECT * FROM properties LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $message = true;
} catch (PDOException $e) {
    $message = "Error fetching properties: " . $e->getMessage();
    exit();
}
