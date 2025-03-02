<div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">Add</span>
                        <span class="fw-light"> Customer</span>
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="formErrors" class="alert alert-danger d-none"></div>
                    <div class="form-group form-group-default">
                        <input id="customerName" name="customerName" type="text" class="form-control" placeholder="Enter customer name" required
                            value="<?php echo htmlspecialchars($customer['name'] ?? ""); ?>">
                    </div>
                    <div class="form-group form-group-default">
                        <input id="customerEmail" name="customerEmail" type="email" class="form-control" placeholder="Enter email" required
                            value="<?php echo htmlspecialchars($customer['email'] ?? ""); ?>">
                    </div>
                    <div class="form-group form-group-default">
                        <input id="phone" name="phone" type="number" maxlength="12" class="form-control" placeholder="923001234567"
                            value="<?php echo htmlspecialchars($customer['contact'] ?? ""); ?>">
                    </div>
                    <div class="form-group form-group-default">
                        <input id="customerPassword" name="customerPassword" type="password" maxlength="12" class="form-control" placeholder="Enter Password"
                            value="<?php echo htmlspecialchars($customer['password'] ?? ""); ?>">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="save" id="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>