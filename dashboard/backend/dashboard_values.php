<?php
require_once "components/db_connection.php";

// Count Agents (users with role 'agent')
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE role = 'agent'");
$stmt->execute();
$agentsCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Count End Users (users with role 'end-user')
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE role = 'end-user'");
$stmt->execute();
$endUsersCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Count Properties
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM properties");
$stmt->execute();
$propertiesCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Count Orders (assuming orders are recorded in the transactions table for property purchases)
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM transactions WHERE transaction_type = 'buy'");
$stmt->execute();
$ordersCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
