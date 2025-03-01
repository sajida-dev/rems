<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">Add</span>
                        <span class="fw-light"> Category</span>
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="formErrors" class="alert alert-danger d-none"></div>

                    <div class="form-group form-group-default">
                        <input id="categoryName" name="categoryName" value="<?php echo htmlspecialchars($category['categoryName'] ?? ''); ?>" type="text" class="form-control" placeholder="Enter category name" required />
                    </div>
                    <div class="form-group form-group-default">
                        <textarea id="categoryDescription" name="categoryDescription" value="<?php echo htmlspecialchars($category['categoryDescription'] ?? ''); ?>" class="form-control" placeholder="Enter description" required></textarea>
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