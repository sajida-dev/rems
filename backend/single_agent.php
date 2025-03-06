<?php
$agent_id = $_GET['agent_id'];

$sql = "SELECT a.*, u.name, u.email, u.contact, u.profile_pic 
        FROM agent a
        JOIN users u ON a.agent_id = u.id
        WHERE a.agent_id = :agent_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':agent_id', $agent_id);
$stmt->execute();
$agent = $stmt->fetch(PDO::FETCH_ASSOC);

$sql_properties = "SELECT * FROM properties WHERE agent_id = :agent_id";
$stmt_properties = $conn->prepare($sql_properties);
$stmt_properties->bindParam(':agent_id', $agent_id);
$stmt_properties->execute();
$properties = $stmt_properties->fetchAll(PDO::FETCH_ASSOC);
