<?php

include_once __DIR__ . '/../components/db_connection.php';

$search    = isset($_POST['search']) ? trim($_POST['search']) : '';
$min_price = isset($_POST['min_price']) ? trim($_POST['min_price']) : '';
$max_price = isset($_POST['max_price']) ? trim($_POST['max_price']) : '';
$bedrooms  = isset($_POST['bedrooms']) ? trim($_POST['bedrooms']) : '';

$limit = 6;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;

$sql = "SELECT p.*, c.name AS category_name 
        FROM properties p 
        LEFT JOIN property_categories c ON p.category_id = c.id 
        WHERE p.status = 'available'";
$params = [];

if (!empty($search)) {
    if (is_numeric($search)) {
        $sql .= " OR (p.rent_price = :search_numeric OR p.old_price = :search_numeric OR p.area = :search_numeric) ";
        $params[':search_numeric'] = $search;
    } else {
        $sql .= " OR (p.location LIKE :search OR p.title LIKE :search OR p.description LIKE :search) ";
        $params[':search'] = '%' . $search . '%';
    }
}

if ($min_price !== '' && $max_price !== '') {
    $sql .= " OR p.rent_price BETWEEN :min_price AND :max_price ";
    $params[':min_price'] = $min_price;
    $params[':max_price'] = $max_price;
} elseif ($min_price !== '') {
    $sql .= " OR p.rent_price >= :min_price ";
    $params[':min_price'] = $min_price;
} elseif ($max_price !== '') {
    $sql .= " OR p.rent_price <= :max_price ";
    $params[':max_price'] = $max_price;
}

if (!empty($bedrooms)) {
    $sql .= " OR p.bedrooms >= :bedrooms ";
    $params[':bedrooms'] = $bedrooms;
}

$sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

$stmt = $conn->prepare($sql);
foreach ($params as $key => $value) {
    if (is_numeric($value)) {
        $stmt->bindValue($key, $value, PDO::PARAM_INT);
    } else {
        $stmt->bindValue($key, $value, PDO::PARAM_STR);
    }
}
$stmt->execute();
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_items = $stmt->fetchColumn();

$total_pages = ceil($total_items / $limit);



// echo "<pre>";
// print_r($properties);
// exit;
$html = '';
if (count($properties) > 0) {
    $html .= '<div class="row">';
    foreach ($properties as $property) {

        $html .= '<div class="col-12 col-md-4 col-lg-6">
    <div class="property-wrap ftco-animate">
        <a href="properties-single.php?id=' . $property['id'] . '" class="img" style="background-image: url(\'' . "dashboard/" . $property['image_url'] . '\');"></a>
        <div class="text position-relative">
            <a href="properties.php?category_id=' . $property['category_id'] . '" class="badge badge-info position-absolute" style="top: 10px; right: 10px;">' . htmlspecialchars($property['category_name']) . '</a>
            <p class="price">
                <span class="old-price">$' . number_format($property['old_price']) . '</span>
                <span class="orig-price">$' . number_format($property['rent_price']) . '<small>/mo</small></span>
            </p>
            <ul class="property_list">
                <li><span class="flaticon-bed"></span>' . $property['bedrooms'] . '</li>
                <li><span class="flaticon-bathtub"></span>' . $property['bathrooms'] . '</li>
                <li><span class="flaticon-floor-plan"></span>' . $property['area'] . ' sqft</li>
            </ul>
            <h3>
                <a href="properties-single.php?id=' . $property['id'] . '">' . htmlspecialchars($property['title']) . '</a>
            </h3>
            <span class="location">' . htmlspecialchars($property['location']) . '</span>
            <a href="properties-single.php?id=' . $property['id'] . '" class="d-flex align-items-center justify-content-center btn-custom">
                <span class="ion-ios-link"></span>
            </a>
        </div>
    </div>
</div>';
    }
    $html .= '</div>';
    echo $html;
} else {
    $html .= '<div class="alert alert-info text-center">No properties found for this search.</div>';
    echo $html;
}
