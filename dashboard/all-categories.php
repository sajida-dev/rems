<?php
$title = "Dashboard";
$page = "";
$mainPage = "Dashboard";
require_once "components/header.php";
require_once "new-category.php"; ?>


<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Add Row</h4>
                <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                    data-bs-target="#addRowModal">
                    <i class="fa fa-plus"></i>
                    Add Row
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Modal -->

            <div class="table-responsive">
                <table id="add-row" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php require_once "components/footer.php"; ?>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Bootstrap JS (for Bootstrap 5, note data-bs- attributes) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize the DataTable
        var table = $("#add-row").DataTable({
            pageLength: 5,
        });

        // Handle the Add Category button click
        $("#addRowButton").click(function() {
            $("#formErrors").addClass("d-none").html("");

            var categoryName = $("#categoryName").val().trim();
            var categoryDescription = $("#categoryDescription").val().trim();

            var errors = [];
            if (categoryName === "") {
                errors.push("Category name is required.");
            }
            if (categoryDescription === "") {
                errors.push("Description is required.");
            }

            if (errors.length > 0) {
                $("#formErrors").removeClass("d-none").html(errors.join("<br>"));
                return;
            }

            var formData = {
                categoryName: categoryName,
                categoryDescription: categoryDescription
            };
            console.log('formData', formData)
            $.ajax({
                url: 'backend/add-category.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Prepare an action cell (example: edit and remove buttons)
                        var action =
                            '<td><div class="form-button-action">' +
                            '<button type="button" data-bs-toggle="tooltip" title="Edit" class="btn btn-link btn-primary btn-lg"><i class="fa fa-edit"></i></button>' +
                            '<button type="button" data-bs-toggle="tooltip" title="Remove" class="btn btn-link btn-danger"><i class="fa fa-times"></i></button>' +
                            '</div></td>';

                        // Add a new row to the DataTable with the category name, description, and action buttons.
                        table.row.add([
                            response.data.name,
                            response.data.description,
                            action
                        ]).draw(false);

                        // Hide the modal
                        $("#addRowModal").modal("hide");
                        // Reset the form
                        $("#addCategoryForm")[0].reset();
                    } else {

                        $("#formErrors").removeClass("d-none").html(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                    $("#formErrors").removeClass("d-none").html("An error occurred. Please try again.");
                }
            });
        });
    });
</script>