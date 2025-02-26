<?php

$limit = 4;

if (isset($limitHomePage)):
    $limit = 4;
endif;

$page = isset($_GET['agent_page']) ? (int)$_GET['agent_page'] : 1;
if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

try {
    $countStmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE role = 'agent'");
    $countStmt->execute();
    $total_agents = $countStmt->fetchColumn();

    $total_pages = ceil($total_agents / $limit);

    $stmt = $conn->prepare("
        SELECT u.id, u.name, u.profile_pic,
            (SELECT COUNT(*) FROM properties p WHERE p.agent_id = u.id) AS property_count
        FROM users u
        WHERE u.role = 'agent'
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $message = true;
} catch (PDOException $e) {
    $message = "Error fetching agents: " . $e->getMessage();
    exit();
}
