<div class="notification-container" style="position: fixed; top: 100px; right: 50px; z-index: 1050;">
    <?php
    if (isset($_SESSION['msg'])) {
        echo '<span class="alert alert-success animate__animated animate__fadeInDown" role="alert">' . $_SESSION['msg'] . '</span>';
        unset($_SESSION['msg']);
    }
    if (isset($_SESSION['msg'])) {
        echo '<div class="alert alert-danger animate__animated animate__fadeInDown" role="alert">' . $_SESSION['msg'] . '</div>';
        unset($_SESSION['msg']);
    }
    ?>
</div>