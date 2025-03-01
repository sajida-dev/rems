<?php
$title = "Customer";
$page = "Update";
$mainPage = "Customer";
require_once "components/header.php";
require_once "backend/edit-customer.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {

    die("Invalid customer id.");
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id AND role = 1");
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    die("Customer not found.");
}

?>
<div class="modal fade" id="updateCustomer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">Update</span>
                        <span class="fw-light"> Customer</span>
                    </h5>
                    <!-- data-bs-dismiss="modal" -->
                    <button type="button" class="close" onclick="closeModel()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="formErrors" class="alert alert-danger d-none"></div>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="form-group form-group-default">
                        <label for="customerName">Name</label>
                        <input id="customerName" name="customerName" type="text" class="form-control" placeholder="Enter customer name" required
                            value="<?php echo htmlspecialchars($customer['name']); ?>">
                    </div>
                    <div class="form-group form-group-default">
                        <label for="customerEmail">Email</label>
                        <input id="customerEmail" name="customerEmail" type="email" class="form-control" placeholder="Enter email" required
                            value="<?php echo htmlspecialchars($customer['email']); ?>">
                    </div>
                    <div class="form-group form-group-default">
                        <label for="customerContact">Contact</label>
                        <input id="customerContact" name="customerContact" type="text" class="form-control" placeholder="Enter contact number"
                            value="<?php echo htmlspecialchars($customer['contact']); ?>">
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
        $("#updateCustomer").modal("show");
    });
</script>