<?php

// Assume $pdo is your PDO connection

// $sql = "
// SELECT p.*
// FROM properties AS p
// JOIN property_categories AS c ON p.category_id = c.id
// JOIN users AS u ON p.agent_id = u.id
// WHERE p.status = 'available'
// ";

// $params = [];

// if (isset($_GET['location'])) {
//     $search = isset($_GET['search']) ? $_GET['search'] : '';

//     if (!empty($search)) {
//         if (is_numeric($search)) {
//             $sql .= " AND (rent_price = :search OR old_price = :search OR area = :search) ";
//             $countSql .= " AND (rent_price = :search OR old_price = :search OR area = :search) ";
//             $params[':search'] = $search;
//         } else {
//             $sql .= " AND (location LIKE :search OR title LIKE :search OR description LIKE :search) ";
//             $countSql .= " AND (location LIKE :search OR title LIKE :search OR description LIKE :search) ";
//             $params[':search'] = '%' . $search . '%';
//         }
//     }
// }

// // Prepare and execute
// $stmt = $conn->prepare($sql);
// $stmt->execute($params);
// $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

// // Now $properties contains all the matching results


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $_SESSION['search'] = trim($_GET['search'] ?? '');
}

// Retrieve the search term from session (or empty string if not set).
$search = isset($_SESSION['search']) ? $_SESSION['search'] : '';

// Pagination variables.
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;

// Start building the SQL query.
$sql = "SELECT * FROM properties WHERE status = 'available' ";
$countSql = "SELECT COUNT(*) FROM properties WHERE status = 'available' ";
$params = [];

// Determine if the search term is numeric or textual.
if (!empty($search)) {
    if (is_numeric($search)) {
        // If numeric, assume the user is searching by price or area.
        // Adjust the condition as needed.
        $sql .= " AND (rent_price = :search OR old_price = :search OR area = :search) ";
        $countSql .= " AND (rent_price = :search OR old_price = :search OR area = :search) ";
        $params[':search'] = $search;
    } else {
        // Otherwise, search by location, title, or description.
        $sql .= " AND (location LIKE :search OR title LIKE :search OR description LIKE :search) ";
        $countSql .= " AND (location LIKE :search OR title LIKE :search OR description LIKE :search) ";
        $params[':search'] = '%' . $search . '%';
    }
}

// Append pagination.
$sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

// Prepare and execute the count query.
$stmtCount = $conn->prepare($countSql);
if (!empty($search)) {
    if (is_numeric($search)) {
        $stmtCount->bindValue(':search', $search, PDO::PARAM_INT);
    } else {
        $stmtCount->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    }
}
$stmtCount->execute();
$total_items = $stmtCount->fetchColumn();
$total_pages = ceil($total_items / $limit);

// Prepare the main query.
$stmt = $conn->prepare($sql);
if (!empty($search)) {
    if (is_numeric($search)) {
        $stmt->bindValue(':search', $search, PDO::PARAM_INT);
    } else {
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    }
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute($params);
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
