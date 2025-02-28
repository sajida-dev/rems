<?php
// backend/filter_properties.php
// include("../components/db_connection.php");

// // Get filter parameters from POST (or fallback to session unified search)
// $search    = isset($_POST['search']) ? trim($_POST['search']) : (isset($_SESSION['search']) ? $_SESSION['search'] : '');
// $min_price = isset($_POST['min_price']) ? trim($_POST['min_price']) : '';
// $max_price = isset($_POST['max_price']) ? trim($_POST['max_price']) : '';
// $bedrooms  = isset($_POST['bedrooms']) ? trim($_POST['bedrooms']) : '';

// // Set up default pagination values (for AJAX you can either use pagination or load all results)
// $limit = 6;
// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// if ($page < 1) {
//     $page = 1;
// }
// $offset = ($page - 1) * $limit;

// $sql = "SELECT p.*, c.name AS category_name 
//         FROM properties p 
//         LEFT JOIN property_categories c ON p.category_id = c.id 
//         WHERE p.status = 'available'";
// $params = [];

// if (!empty($search)) {
//     if (is_numeric($search)) {
//         $sql .= " AND (rent_price = :search_numeric OR old_price = :search_numeric OR area = :search_numeric) ";
//         $params[':search_numeric'] = $search;
//     } else {
//         $sql .= " AND (location LIKE :search_text OR title LIKE :search_text OR description LIKE :search_text) ";
//         $params[':search_text'] = '%' . $search . '%';
//     }
// }

// // Apply price filters if provided.
// if ($min_price !== '' && $max_price !== '') {
//     $sql .= " AND rent_price BETWEEN :min_price AND :max_price ";
//     $params[':min_price'] = $min_price;
//     $params[':max_price'] = $max_price;
// } elseif ($min_price !== '') {
//     $sql .= " AND rent_price >= :min_price ";
//     $params[':min_price'] = $min_price;
// } elseif ($max_price !== '') {
//     $sql .= " AND rent_price <= :max_price ";
//     $params[':max_price'] = $max_price;
// }

// // Apply bedrooms filter.
// if (!empty($bedrooms)) {
//     $sql .= " AND bedrooms >= :bedrooms ";
//     $params[':bedrooms'] = $bedrooms;
// }

// // Append pagination (if using pagination)
// $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

// // Prepare and execute the statement.
// $stmt = $conn->prepare($sql);

// // Bind all parameters.
// foreach ($params as $key => $value) {
//     // Choose parameter type based on value type.
//     if (is_numeric($value)) {
//         $stmt->bindValue($key, $value, PDO::PARAM_INT);
//     } else {
//         $stmt->bindValue($key, $value, PDO::PARAM_STR);
//     }
// }

// $stmt->execute();
// $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);


// session_start();
// Use __DIR__ to correctly include the db_connection.php file
include_once __DIR__ . '/../components/db_connection.php';

// Assume $search and other filter variables are set as before.
$search    = isset($_POST['search']) ? trim($_POST['search']) : '';
$min_price = isset($_POST['min_price']) ? trim($_POST['min_price']) : '';
$max_price = isset($_POST['max_price']) ? trim($_POST['max_price']) : '';
$bedrooms  = isset($_POST['bedrooms']) ? trim($_POST['bedrooms']) : '';

// Pagination variables
$limit = 6;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;

// Build the base query.
// Note: Here we alias properties as 'p' for clarity.
// $sql = "SELECT p.* FROM properties p WHERE p.status = 'available' ";

$sql = "SELECT p.*, c.name AS category_name 
        FROM properties p 
        LEFT JOIN property_categories c ON p.category_id = c.id 
        WHERE p.status = 'available'";
$params = [];

// Apply search filter (qualify all column names with alias p.)
if (!empty($search)) {
    if (is_numeric($search)) {
        $sql .= " AND (p.rent_price = :search_numeric OR p.old_price = :search_numeric OR p.area = :search_numeric) ";
        $params[':search_numeric'] = $search;
    } else {
        $sql .= " AND (p.location LIKE :search OR p.title LIKE :search OR p.description LIKE :search) ";
        $params[':search'] = '%' . $search . '%';
    }
}

// Apply price filters if provided.
if ($min_price !== '' && $max_price !== '') {
    $sql .= " AND p.rent_price BETWEEN :min_price AND :max_price ";
    $params[':min_price'] = $min_price;
    $params[':max_price'] = $max_price;
} elseif ($min_price !== '') {
    $sql .= " AND p.rent_price >= :min_price ";
    $params[':min_price'] = $min_price;
} elseif ($max_price !== '') {
    $sql .= " AND p.rent_price <= :max_price ";
    $params[':max_price'] = $max_price;
}

// Apply bedrooms filter.
if (!empty($bedrooms)) {
    $sql .= " AND p.bedrooms >= :bedrooms ";
    $params[':bedrooms'] = $bedrooms;
}

// Append pagination (directly interpolating integer values)
$sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

// Prepare and execute the statement.
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

// Output the properties as needed...

// Output the HTML for each property.
if (count($properties) > 0) {
    echo '<div class="row">';
    foreach ($properties as $property) {
?>
        <div class="col-12 col-md-4 col-lg-6">
            <div class="property-wrap ftco-animate">
                <a href="properties-single.php?id=<?php echo $property['id']; ?>" class="img" style="background-image: url('<?php echo $property['image_url']; ?>');"></a>


                <div class="text position-relative">
                    <a href="properties.php?category_id=<?php echo $property['category_id']; ?>"
                        class="badge badge-info position-absolute"
                        style="top: 10px; right: 10px;">
                        <?php echo htmlspecialchars($property['category_name']); ?>
                    </a>

                    <p class="price">
                        <span class="old-price">$<?php echo number_format($property['old_price']); ?></span>
                        <span class="orig-price">$<?php echo number_format($property['rent_price']); ?><small>/mo</small></span>
                    </p>
                    <ul class="property_list">
                        <li><span class="flaticon-bed"></span><?php echo $property['bedrooms']; ?></li>
                        <li><span class="flaticon-bathtub"></span><?php echo $property['bathrooms']; ?></li>
                        <li><span class="flaticon-floor-plan"></span><?php echo $property['area']; ?> sqft</li>
                    </ul>
                    <h3>
                        <a href="properties-single.php?id=<?php echo $property['id']; ?>">
                            <?php echo htmlspecialchars($property['title']); ?>
                        </a>
                    </h3>
                    <span class="location"><?php echo htmlspecialchars($property['location']); ?></span>
                    <a href="properties-single.php?id=<?php echo $property['id']; ?>" class="d-flex align-items-center justify-content-center btn-custom">
                        <span class="ion-ios-link"></span>
                    </a>
                </div>

            </div>
        </div>
<?php
    }
    echo '</div>';
} else {
    echo '<div class="alert alert-info text-center">No properties found for this search.</div>';
}
?>