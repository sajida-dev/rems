<div class="container mt-3 z-3">
    <?php
    if (isset($_SESSION['success_msg'])) {
        echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_msg'] . '</div>';
        unset($_SESSION['success_msg']);
    }
    if (isset($_SESSION['error_msg'])) {
        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_msg'] . '</div>';
        unset($_SESSION['error_msg']);
    }
    ?>
</div>