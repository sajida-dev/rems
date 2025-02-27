<?php
$data = [10, "Jbd", "Lahore", 28, "China"];

for ($i = 0; $i < 5; $i++) { ?>

    <div>
        <img src="assets/img/bg-404.jpeg" width="100px" alt="">
        <h2 style="border: 1px solid red;">
            <?php echo $data[$i]; ?>
        </h2>

    </div>

<?php } ?>