<?php
$title = "Dashboard";
$page = "";
$mainPage = "Dashboard";
$mainPageUrl = "";
$pageUrl = "";
require_once "components/header.php";
require_once "backend/admin-dashboard-values.php";
require_once "backend/agent-dashboard-values.php";

$adminRole = ['3', 'admin'];
$agentRole = ['2', 'agent'];
// dashboard cards
if (in_array($_SESSION['role'], $adminRole)) {
  include_once "admin-dashboard-cards.php";
} else {
  include_once "agent-dashboard-cards.php";
}
// Footer
require_once "components/footer.php";
