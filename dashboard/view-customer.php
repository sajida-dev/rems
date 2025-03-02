<?php
$title = "Property";
$page = "View";
$mainPage = "Property";
require_once "components/header.php";
$customerId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($customerId <= 0) {
    die("Invalid customer id.");
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id AND role = 'end-user'");
$stmt->bindParam(':id', $customerId, PDO::PARAM_INT);
$stmt->execute();
$customer = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$customer) {
    die("Customer not found.");
}

$stmtTx = $conn->prepare("
    SELECT t.*, p.title AS property_title 
    FROM transactions t 
    LEFT JOIN properties p ON t.property_id = p.id 
    WHERE t.user_id = :customerId 
    ORDER BY t.created_at DESC
");
$stmtTx->bindParam(':customerId', $customerId, PDO::PARAM_INT);
$stmtTx->execute();
$transactions = $stmtTx->fetchAll(PDO::FETCH_ASSOC);

$groupedTransactions = [];
foreach ($transactions as $tx) {
    $type = strtolower($tx['transaction_type']);
    $groupedTransactions[$type][] = $tx;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    .customer-details {
        margin: 20px auto;
        max-width: 1200px;
        background: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .contact-details {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
        background: #f8f8f8;
    }

    .transaction-group {
        margin-bottom: 30px;
    }

    .transaction-group h5 {
        border-bottom: 1px solid #ddd;
        padding-bottom: 5px;
        margin-bottom: 15px;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .profile-img {
        max-width: 150px;
        border-radius: 50%;
        margin-bottom: 15px;
    }
</style>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="fw-mediumbold"><?php echo htmlspecialchars($customer['name']); ?></h5>
        </div>
        <div class="card-body">
            <div class="container customer-details">
                <div class="row">
                    <!-- Left Column: Transaction Details -->
                    <div class="col-md-8">
                        <h3>Transaction Details</h3>
                        <?php if (!empty($groupedTransactions)): ?>
                            <?php foreach ($groupedTransactions as $type => $txs): ?>
                                <div class="transaction-group">
                                    <h5><?php echo ucfirst($type); ?> Transactions</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Property</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($txs as $tx): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($tx['id']); ?></td>
                                                    <td><?php echo htmlspecialchars($tx['property_title'] ?? 'N/A'); ?></td>
                                                    <td><?php echo htmlspecialchars($tx['status']); ?></td>
                                                    <td><?php echo htmlspecialchars($tx['created_at']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="mt-4 d-flex justify-content-center">No transactions found for this customer.</p>
                        <?php endif; ?>
                    </div>
                    <!-- Right Column: Contact Details -->
                    <div class="col-md-4">
                        <div class="contact-details">
                            <h4>Contact Details</h4>
                            <?php if (!empty($customer['profile_pic'])): ?>
                                <img src="<?php echo htmlspecialchars($customer['profile_pic'] ?? ""); ?>" alt="Profile Picture" class="profile-img img-fluid">
                            <?php else: ?>
                                <img src="assets/img/avatar.png" alt="Default Avatar" class="profile-img img-fluid">
                            <?php endif; ?>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($customer['name']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($customer['email']); ?></p>
                            <p><strong>Contact:</strong> <?php echo htmlspecialchars($customer['contact']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "components/footer.php"; ?>
<!-- Optional: include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>