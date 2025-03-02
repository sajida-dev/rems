<?php
$title = "Properties";
$page = "All";
$mainPage = "Properties";
require_once "components/header.php";
require_once "backend/select-all-perperties.php"
?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title"> Properties</h4>
                <a href="new-property.php" class="btn btn-primary btn-round ms-auto"><i class="fa fa-plus"></i>
                    Add Property</a>
            </div>
        </div>
        <div class="card-body">
            <!-- Modal -->

            <div class="table-responsive">
                <table id="propertyTable" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Name</th>
                            <th>Agent</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr.</th>
                            <th>Name</th>
                            <th>Agent</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($properties as $property):
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($i); ?></td>
                                <td><?php echo htmlspecialchars($property['title']); ?></td>
                                <td><?php echo htmlspecialchars($property['agent_name']); ?></td>
                                <td><?php echo htmlspecialchars($property['location']); ?></td>
                                <td>$<?php echo number_format($property['rent_price'], 2); ?></td>

                                <td>
                                    <div class="form-button-action">
                                        <a href="update-property.php?id=<?php echo htmlspecialchars($property['id']); ?>" class="btn btn-link btn-primary btn-sm ">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="view-property.php?id=<?php echo htmlspecialchars($property['id']); ?>" class="btn btn-link btn-primary btn-sm ">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="delete-property.php?id=<?php echo htmlspecialchars($property['id']); ?>" class="btn btn-link btn-sm btn-danger">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php require_once "components/footer.php"; ?>



<script>
    $(document).ready(function() {
        $("#propertyTable").DataTable({
            pageLength: 10
        });
    });
</script>