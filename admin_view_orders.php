<?php
include 'config/db.php';
include 'includes/header.php';


if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

$query = "SELECT o.id, u.name as customer_name, o.total_price, o.order_date, o.status 
          FROM orders o 
          JOIN users u ON o.user_id = u.id 
          ORDER BY o.order_date DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-file-invoice-dollar text-primary"></i> Customer Orders</h2>
        <a href="admin_dashboard.php" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th width="10%">Order #</th>
                        <th width="25%">Customer Name</th>
                        <th width="20%">Date & Time</th>
                        <th width="15%">Total Price</th>
                        <th width="15%">Status</th>
                        <th width="15%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="fw-bold text-primary">#<?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                <td>
                                    <small class="text-muted">
                                        <?php echo date('M d, Y', strtotime($row['order_date'])); ?><br>
                                        <?php echo date('h:i A', strtotime($row['order_date'])); ?>
                                    </small>
                                </td>
                                <td class="fw-bold text-success">
                                    $<?php echo number_format($row['total_price'], 2); ?>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-success px-3">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="invoice.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-eye"></i> View Bill
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-box-open fa-3x mb-3"></i>
                                <p>No orders have been placed yet.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>