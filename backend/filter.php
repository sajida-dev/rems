<?php
$search       = trim($_POST['search'] ?? '');
$category_id  = intval($_POST['category_id'] ?? 0);
$location     = trim($_POST['location'] ?? '');
$min_price    = floatval($_POST['min_price'] ?? 0);
$max_price    = floatval($_POST['max_price'] ?? 0);
$bedrooms     = intval($_POST['bedrooms'] ?? 0);
$amenities    = $_POST['amenities'] ?? [];
$agent_id     = isset($_GET['agent_id']) ? intval($_GET['agent_id']) : 0;

$sql = "SELECT DISTINCT p.*, c.name AS category_name
        FROM properties p
        LEFT JOIN property_categories c ON p.category_id = c.id ";

if (!empty($amenities)) {
    $sql .= "JOIN property_amenities pa ON p.id = pa.property_id ";
}

$sql .= "WHERE 1=1 ";

$params = [];


if (!empty($search)) {
    $sql .= "AND (p.title LIKE :search OR p.description LIKE :search OR p.location LIKE :search) ";
    $params[':search'] = "%" . $search . "%";
}

if ($category_id > 0) {
    $sql .= "AND p.category_id = :category_id ";
    $params[':category_id'] = $category_id;
}

if (!empty($location)) {
    $sql .= "AND p.location LIKE :location ";
    $params[':location'] = "%" . $location . "%";
}




if ($min_price > 0) {
    $sql .= "AND p.rent_price >= :min_price ";
    $params[':min_price'] = $min_price;
}

if ($max_price > 0) {
    $sql .= "AND p.rent_price <= :max_price ";
    $params[':max_price'] = $max_price;
}

if ($bedrooms > 0) {
    $sql .= "AND p.bedrooms >= :bedrooms ";
    $params[':bedrooms'] = $bedrooms;
}


if ($agent_id > 0) {
    $sql .= "AND p.agent_id = :agent_id ";
    $params[':agent_id'] = $agent_id;
}

if (!empty($amenities)) {
    $amenityPlaceholders = [];
    foreach ($amenities as $index => $amenity_id) {
        $ph = ":amenity_" . $index;
        $amenityPlaceholders[] = $ph;
        $params[$ph] = intval($amenity_id);
    }
    $sql .= "AND pa.amenity_id IN (" . implode(", ", $amenityPlaceholders) . ") ";
}

$sql .= "GROUP BY p.id ORDER BY p.created_at DESC";

$limit = 6;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;
$sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

$stmt = $conn->prepare($sql);
foreach ($params as $key => $value) {
    $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
    $stmt->bindValue($key, $value, $type);
}
$stmt->execute();
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_items = $stmt->fetchColumn();

$total_pages = ceil($total_items / $limit);
