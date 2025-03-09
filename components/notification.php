<link rel="stylesheet" href="css/custom-notify.css">
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