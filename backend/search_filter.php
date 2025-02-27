<?php

// Assume $pdo is your PDO connection

$sql = "
SELECT p.*
FROM properties AS p
JOIN property_categories AS c ON p.category_id = c.id
JOIN users AS u ON p.agent_id = u.id
WHERE p.status = 'available'
";

$params = [];

// If user entered a location
if (!empty($_GET['location'])) {
    $sql .= " AND p.location LIKE :location";
    $params[':location'] = '%' . $_GET['location'] . '%';
}

// If user entered min/max price
if (!empty($_GET['min_price']) && !empty($_GET['max_price'])) {
    $sql .= " AND p.price BETWEEN :min_price AND :max_price";
    $params[':min_price'] = $_GET['min_price'];
    $params[':max_price'] = $_GET['max_price'];
}

// If user selected a category
if (!empty($_GET['category_id'])) {
    $sql .= " AND p.category_id = :category_id";
    $params[':category_id'] = $_GET['category_id'];
}

// If user wants a minimum number of bedrooms
if (!empty($_GET['min_bedrooms'])) {
    $sql .= " AND p.bedrooms >= :min_bedrooms";
    $params[':min_bedrooms'] = $_GET['min_bedrooms'];
}

// If user entered a keyword
if (!empty($_GET['keyword'])) {
    $sql .= " AND (p.title LIKE :keyword OR p.description LIKE :keyword)";
    $params[':keyword'] = '%' . $_GET['keyword'] . '%';
}

// Prepare and execute
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Now $properties contains all the matching results
