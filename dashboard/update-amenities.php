<?php
$title = "Amenities";
$page = "Update";
$mainPage = "Amenities";
require_once "components/header.php";
require_once "backend/edit-amenities.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare("SELECT * FROM amenities WHERE id = :id");
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$amenities = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="modal fade" id="updateAmenities" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">Update</span>
                        <span class="fw-light"> Amenities</span>
                    </h5>
                    <button type="button" onclick="closeModel()" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="formErrors" class="alert alert-danger d-none"></div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group form-group-default">
                        <input id="amenitiesName" name="amenitiesName" value="<?php echo htmlspecialchars($amenities['name']); ?>" type="text" class="form-control" placeholder="Enter amenities name" required />
                    </div>
                    <div class="form-group form-group-default">
                        <textarea id="amenitiesDescription" name="amenitiesDescription" class="form-control" placeholder="Enter description" required><?php echo htmlspecialchars($amenities['description']); ?></textarea>
                    </div>


                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="save" id="submit" class="btn btn-primary">Update</button>
                    <button type="button" onclick="closeModel()" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "components/footer.php"; ?>


<script>
    $(document).ready(function() {
        $("#updateAmenities").modal("show");
    });
</script>