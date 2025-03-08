<?php
$stmtAmenity = $conn->prepare("SELECT id, name FROM amenities ORDER BY name ASC");
$stmtAmenity->execute();
$allAmenities = $stmtAmenity->fetchAll(PDO::FETCH_ASSOC);
