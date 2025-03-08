<?php
require_once "components/db_connection.php";

if (session_status() === PHP_SESSION_NONE) {
    $cookieLifetime = 86400 * 5;
    session_set_cookie_params([
        'lifetime' => $cookieLifetime,
        'path'     => '/',
        'domain'   => '',
        'secure'   => false,
        'httponly' => true,
        'samesite' => 'strict'
    ]);
    session_start();
}
$role = ['2', '3', 'agent', 'admin'];
if (!isset($_SESSION['id']) || (!in_array($_SESSION['role'], $role))) {
    echo "<script>window.location.href = '../index.php';</script>";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo $title; ?></title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport" />
    <link
        rel="icon"
        href="assets/img/kaiadmin/favicon.ico"
        type="image/x-icon" />
    <script
        src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"
        async
        defer></script>

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />


</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php require_once "components/sidebar.php"; ?>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <?php require_once "components/logo-header.php"; ?>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <?php require_once "components/nav-header.php"; ?>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <?php require_once "components/page-header.php"; ?>
                    <div class="row">