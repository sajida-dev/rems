<?php
$title = "Category";
$page = "Update";
$mainPage = "Category";
require_once "components/header.php";
require_once "backend/edit-category.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare("SELECT * FROM property_categories WHERE id = :id");
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$category = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="modal fade" id="updateCategory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">Update</span>
                        <span class="fw-light"> Category</span>
                    </h5>
                    <button type="button" onclick="closeModel()" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="formErrors" class="alert alert-danger d-none"></div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group form-group-default">
                        <input id="categoryName" name="categoryName" value="<?php echo htmlspecialchars($category['name']); ?>" type="text" class="form-control" placeholder="Enter category name" required />
                    </div>
                    <div class="form-group form-group-default">
                        <textarea id="categoryDescription" name="categoryDescription" class="form-control" placeholder="Enter description" required><?php echo htmlspecialchars($category['description']); ?></textarea>
                    </div>


                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="save" id="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-danger" onclick="closeModel()" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "components/footer.php"; ?>


<script>
    $(document).ready(function() {
        $("#updateCategory").modal("show");
    });
</script>