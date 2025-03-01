<?php session_start(); ?>
<?php

if (isset($_SESSION['id'])) {
  if ($_SESSION['role'] == 'agent' || $_SESSION['role'] == 'admin'):
    header('location: dashboard/index.php');
    exit;
  else:
    header("Location: index.php");
    exit;
  endif;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Login</title>
  <meta
    content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    name="viewport" />
  <link
    rel="icon"
    href="dashboard/assets/img/kaiadmin/favicon.ico"
    type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="dashboard/assets/js/plugin/webfont/webfont.min.js"></script>
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
        urls: ["dashboard/assets/css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="dashboard/assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="dashboard/assets/css/plugins.min.css" />
  <link rel="stylesheet" href="dashboard/assets/css/kaiadmin.min.css" />
</head>

<body>
  <div class="wrapper mt-5">
    <?php require_once "components/db_connection.php";
    require_once "backend/login_submit.php";  ?>
    <div class="container">
      <div class="page-inner">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-4 ">
            <div class="card">

              <form action="" method="POST">
                <div class="card-header">
                  <div class="card-title">Login Form</div>
                  <?php
                  if (!empty($msg)) {
                    echo $msg;
                  }
                  ?>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email">
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
                  </div>
                </div>
                <div class="card-action">
                  <button class="btn btn-sm btn-success" type="submit" name="login">Login</button>
                  <span class="container"><a href="register.php">Register Here</a></span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>



  </div>
  <!--   Core JS Files   -->
  <script src=" dashboard/assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="dashboard/assets/js/core/popper.min.js"></script>
  <script src="dashboard/assets/js/core/bootstrap.min.js"></script>

  <!-- jQuery Scrollbar -->
  <script src="dashboard/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

  <!-- Chart JS -->
  <script src="dashboard/assets/js/plugin/chart.js/chart.min.js"></script>

  <!-- jQuery Sparkline -->
  <script src="dashboard/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

  <!-- Chart Circle -->
  <script src="dashboard/assets/js/plugin/chart-circle/circles.min.js"></script>

  <!-- Datatables -->
  <script src="dashboard/assets/js/plugin/datatables/datatables.min.js"></script>

  <!-- Bootstrap Notify -->
  <script src="dashboard/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

  <!-- jQuery Vector Maps -->
  <script src="dashboard/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
  <script src="dashboard/assets/js/plugin/jsvectormap/world.js"></script>

  <!-- Google Maps Plugin -->
  <script src="dashboard/assets/js/plugin/gmaps/gmaps.js"></script>

  <!-- Sweet Alert -->
  <script src="dashboard/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

  <!-- Kaiadmin JS -->
  <script src="dashboard/assets/js/kaiadmin.min.js"></script>
</body>

</html>