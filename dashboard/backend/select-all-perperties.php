<?php



if ($_SESSION['role'] == 'agent'):
    $id = $_SESSION['id'];
    $sql = "SELECT p.id, p.title, p.location, p.rent_price, u.name AS agent_name
    FROM properties p
    LEFT JOIN users u ON p.agent_id = u.id
    WHERE u.id = ?
    ORDER BY p.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
else:
    $sql = "SELECT p.id, p.title, p.location, p.rent_price, u.name AS agent_name
    FROM properties p
    LEFT JOIN users u ON p.agent_id = u.id
    ORDER BY p.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
endif;

$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
