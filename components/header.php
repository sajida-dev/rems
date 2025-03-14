<?php include_once "db_connection.php";
if (session_status() === PHP_SESSION_NONE) {
    $cookieLifetime = 86400 * 30;
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
require_once "components/notification.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo ($title ?? 'Uptown') ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">


    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">Uptown</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
                    <?php if (isset($_SESSION['id'])): ?>
                        <li class="nav-item"><a href="<?php
                                                        if ($_SESSION['role'] == 'agent'):
                                                            echo "dashboard/profile.php";
                                                        else:
                                                            echo "profile.php";
                                                        endif;
                                                        ?>" class="nav-link">Profile</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="agent.php" class="nav-link">Agent</a></li>
                    <li class="nav-item"><a href="services.php" class="nav-link">Services</a></li>
                    <li class="nav-item"><a href="properties.php" class="nav-link">Properties</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>


                    <?php if (!isset($_SESSION['id'])): ?>
                        <li class="nav-item">
                            <a href="login.php" class="nav-link">Login</a>
                        </li>
                        <li class="nav-item text-white">
                            <a href="register.php" class="btn btn-primary nav-link">Register</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a href="index.php" class="nav-link"><?php echo htmlspecialchars($_SESSION['name']); ?></a></li>
                        <li class="nav-item text-white">
                            <a href="logout.php" class="btn btn-primary nav-link">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->