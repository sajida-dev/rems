<?php

try {
    $stmt = $conn->query("SELECT COUNT(*) FROM properties");
    $total_properties = $stmt->fetchColumn();
    if (!$total_properties) {
        $total_properties = 0;
    }
} catch (PDOException $e) {
    $total_properties = 0;
}


try {
    $stmt = $conn->query("SELECT AVG(property_count) FROM (SELECT COUNT(*) AS property_count FROM properties GROUP BY agent_id) AS sub");
    $average_house = $stmt->fetchColumn();
    $average_house = round($average_house);
    if (!$average_house) {
        $average_house = 0;
    }
} catch (PDOException $e) {
    $average_house = 0;
}
