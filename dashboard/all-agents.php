<?php
$title = "All Agent";
$page = "All";
$mainPage = "Agent";
require_once "components/header.php";
require_once "backend/add-agent.php"; ?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title"> Agent</h4>
                <a href="new-agent.php" class="btn btn-primary btn-round ms-auto">
                    <i class="fa fa-plus"></i>
                    Add Agent
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Modal -->

            <div class="table-responsive">
                <table id="agentTable" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Agency</th>
                            <th>Experience</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Agency</th>
                            <th>Experience</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($agents as $cat): ?>
                            <tr>
                                <td>
                                    <div class="avatar avatar-lg">
                                        <img src="../<?php echo htmlspecialchars($cat['profile_pic'] ?? "images/avator.png"); ?>" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($cat['name']); ?></td>
                                <td><?php echo htmlspecialchars($cat['email']); ?></td>
                                <td><?php echo htmlspecialchars($cat['agency'] ?? "NILL"); ?></td>
                                <td><?php echo htmlspecialchars($cat['experience'] ?? "NILL"); ?></td>
                                <td>
                                    <div class="form-button-action">
                                        <a href="update-agent.php?id=<?php echo htmlspecialchars($cat['id']); ?>" class="btn btn-link btn-primary btn-sm ">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="view-agent.php?id=<?php echo htmlspecialchars($cat['id']); ?>" class="btn btn-link btn-primary btn-sm ">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="delete-agent.php?id=<?php echo htmlspecialchars($cat['id']); ?>" class="btn btn-link btn-sm btn-danger">
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
        $("#agentTable").DataTable({
            pageLength: 10
        });
    });
</script>