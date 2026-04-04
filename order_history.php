<?php
session_start();
include 'config/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container my-5">
    <h2 class="mb-4"><i class="fa-solid fa-box-open text-success"></i> My Order History</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="fw-bold text-success">#<?php echo $row['id']; ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['order_date'])); ?></td>
                                <td>$<?php echo number_format($row['total_price'], 2); ?></td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="invoice.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-success btn-sm">
                                        View Bill
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fa-solid fa-receipt fa-4x text-muted mb-3"></i>
            <p class="lead">You haven't placed any orders yet.</p>
            <a href="products.php" class="btn btn-success">Start Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>