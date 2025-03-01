<?php
$title = "Category";
$page = "All";
$mainPage = "Category";
require_once "components/header.php";
require_once "new-category.php";
require_once "backend/add-category.php"; ?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title"> Categories</h4>
                <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                    data-bs-target="#addRowModal">
                    <i class="fa fa-plus"></i>
                    Add Category
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Modal -->

            <div class="table-responsive">
                <table id="categoryTable" class="display table table-striped table-hover">
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
                        <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cat['id']); ?></td>
                                <td><?php echo htmlspecialchars($cat['name']); ?></td>
                                <td><?php echo htmlspecialchars($cat['description']); ?></td>
                                <td>
                                    <div class="form-button-action">
                                        <a href="update-category.php?id=<?php echo htmlspecialchars($cat['id']); ?>" class="btn btn-link btn-primary btn-lg ">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <!-- data-bs-toggle="modal"
                                            data-bs-target="#updateCategory" -->
                                        <a href="delete-category.php?id=<?php echo htmlspecialchars($cat['id']); ?>" class="btn btn-link btn-danger">
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
        $("#categoryTable").DataTable({
            pageLength: 10
        });
    });
</script>