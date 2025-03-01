<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">Add</span>
                        <span class="fw-light"> Amenity</span>
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="formErrors" class="alert alert-danger d-none"></div>

                    <div class="form-group form-group-default">
                        <input id="amenitiesName" name="amenitiesName" value="<?php echo htmlspecialchars($amenities['amenitiesName'] ?? ''); ?>" type="text" class="form-control" placeholder="Enter amenities name" required />
                    </div>
                    <div class="form-group form-group-default">
                        <textarea id="amenitiesDescription" name="amenitiesDescription" value="<?php echo htmlspecialchars($amenities['amenitiesDescription'] ?? ''); ?>" class="form-control" placeholder="Enter description" required></textarea>
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