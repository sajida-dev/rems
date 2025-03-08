<?php

$agentId = $_SESSION['id'];

$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM properties WHERE agent_id = :agent_id");
$stmt->bindParam(':agent_id', $agentId);
$stmt->execute();
$totalPropertiesCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM properties WHERE agent_id = :agent_id AND status = 'available'");
$stmt->bindParam(':agent_id', $agentId);
$stmt->execute();
$availablePropertiesCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];


$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM properties WHERE agent_id = :agent_id AND status = 'sold'");
$stmt->bindParam(':agent_id', $agentId);
$stmt->execute();
$soldPropertiesCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM properties WHERE agent_id = :agent_id AND status = 'rented'");
$stmt->bindParam(':agent_id', $agentId);
$stmt->execute();
$rentedPropertiesCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
