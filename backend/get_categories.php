<?php


$stmtCat = $conn->prepare("SELECT id, name FROM property_categories ORDER BY name ASC");
$stmtCat->execute();
$categories = $stmtCat->fetchAll(PDO::FETCH_ASSOC);
