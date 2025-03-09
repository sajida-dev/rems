<?php

include "components/db_connection.php";
$agent_id = $_GET['agent_id'];

$sql = "SELECT a.*, u.name, u.email, u.contact, u.profile_pic 
        FROM agent a
        JOIN users u ON a.agent_id = u.id
        WHERE a.agent_id = :agent_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':agent_id', $agent_id);
$stmt->execute();
$agent = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt_properties = $conn->prepare("
    SELECT p.*, c.name AS category_name, 
           GROUP_CONCAT(a.name SEPARATOR ', ') AS amenities
    FROM properties p
    LEFT JOIN property_categories c ON p.category_id = c.id
    LEFT JOIN property_amenities pa ON p.id = pa.property_id
    LEFT JOIN amenities a ON pa.amenity_id = a.id
    WHERE p.agent_id = :agent_id
    GROUP BY p.id
    ORDER BY p.created_at DESC
");
$stmt_properties->bindParam(':agent_id', $agent_id);
$stmt_properties->execute();
$properties = $stmt_properties->fetchAll(PDO::FETCH_ASSOC);
