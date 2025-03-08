<?php

$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE role = 'agent'");
$stmt->execute();
$agentsCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE role = 'end-user'");
$stmt->execute();
$endUsersCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM properties");
$stmt->execute();
$propertiesCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM transactions WHERE transaction_type = 'buy'");
$stmt->execute();
$ordersCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
