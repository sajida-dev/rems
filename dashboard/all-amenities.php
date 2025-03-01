<?php
$title = "Amenities";
$page = "All";
$mainPage = "Amenities";
require_once "components/header.php";
require_once "new-amenities.php";
require_once "backend/add-amenities.php"; ?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title"> Amenities</h4>
                <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                    data-bs-target="#addRowModal">
                    <i class="fa fa-plus"></i>
                    Add Amenity
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Modal -->

            <div class="table-responsive">
                <table id="amenitiesTable" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr.</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($amenities as $ame): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($ame['id']); ?></td>
                                <td><?php echo htmlspecialchars($ame['name']); ?></td>
                                <td><?php echo htmlspecialchars($ame['description']); ?></td>
                                <td>
                                    <div class="form-button-action">
                                        <a href="update-amenities.php?id=<?php echo htmlspecialchars($ame['id']); ?>" class="btn btn-link btn-primary btn-lg ">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a href="delete-amenities.php?id=<?php echo htmlspecialchars($ame['id']); ?>" class="btn btn-link btn-danger">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php require_once "components/footer.php"; ?>



<script>
    $(document).ready(function() {
        $("#amenitiesTable").DataTable({
            pageLength: 10
        });
    });
</script>