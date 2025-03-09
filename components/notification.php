<!-- <div class="container mt-3 z-3">
    <?php
    if (isset($_SESSION['msg'])) {
        echo '<div class="alert alert-success animate__animated animate__fadeInDown" role="alert">' . $_SESSION['msg'] . '</div>';
        unset($_SESSION['msg']);
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger animate__animated animate__fadeInDown" role="alert">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    ?>
</div> -->
<link rel="stylesheet" href="css/custom-notify.css">k
<div class="toast-panel">
    <?php
    if (isset($_SESSION['msg'])) {
        echo '<div class="toast-item success">
        <div class="toast success">
            <label for="t-success" class="close"></label>
            <h3>Success!</h3>
            <p>' . $_SESSION['msg'] . '</p>
        </div>
    </div>';
        unset($_SESSION['msg']);
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="toast-item success">
        <div class="toast success">
            <label for="t-success" class="close"></label>
            <h3>Success!</h3>
            <p>' . $_SESSION['error'] . '</p>
        </div>
    </div>';
        unset($_SESSION['error']);
    }
    ?>

</div>