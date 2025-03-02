<?php

$sql = "SELECT p.id, p.title, p.location, p.rent_price, u.name AS agent_name
    FROM properties p
    LEFT JOIN users u ON p.agent_id = u.id
    ORDER BY p.created_at DESC";

# if user is agent only show current agent properties
if ($_SESSION['role'] == 2):
    $id = $_SESSION['id'];
    $sql = "SELECT p.id, p.title, p.location, p.rent_price, u.name AS agent_name
    FROM properties p
    LEFT JOIN users u ON p.agent_id = u.id
    WHERE u.id = $id
    ORDER BY p.created_at DESC";
endif;

$stmt = $conn->prepare($sql);
$stmt->execute();
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
