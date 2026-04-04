<?php
session_start();
include 'config/db.php';
include 'includes/header.php';

$order_id = $_GET['id'];
// Fetch Order Details
$order_data = mysqli_query($conn, "SELECT * FROM orders WHERE id = $order_id")->fetch_assoc();
// Fetch Items
$items = mysqli_query($conn, "SELECT p.name, oi.price, oi.quantity FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = $order_id");
?>

<div class="container my-5">
    <div class="card shadow-lg border-0 p-5">
        <div class="row mb-4">
            <div class="col-6">
                <h3 class="text-success fw-bold">🛒 GROCERY STORE</h3>
                <p class="text-muted">123 Fresh Way, Market City<br>Phone: +1 234-567-890</p>
            </div>
            <div class="col-6 text-end">
                <h2 class="text-uppercase">Invoice</h2>
                <p class="mb-0"><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
                <p><strong>Date:</strong> <?php echo date('M d, Y', strtotime($order_data['order_date'])); ?></p>
            </div>
        </div>

        <table class="table table-borderless border-top border-bottom">
            <thead class="bg-light">
                <tr>
                    <th>Item Description</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $items->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td class="text-center">$<?php echo number_format($row['price'], 2); ?></td>
                    <td class="text-center"><?php echo $row['quantity']; ?></td>
                    <td class="text-end">$<?php echo number_format($row['price'] * $row['quantity'], 2); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="row justify-content-end mt-4">
            <div class="col-4 text-end">
                <h4 class="fw-bold">Grand Total: <span class="text-success">$<?php echo number_format($order_data['total_price'], 2); ?></span></h4>
            </div>
        </div>
<div class="text-center mt-5 no-print">
    <button onclick="window.print()" class="btn btn-outline-dark me-2">
        <i class="fa-solid fa-print"></i> Print Bill
    </button>
    
    <a href="index.php" class="btn btn-success">
        <i class="fa-solid fa-house"></i> Back to Home
    </a>
</div>
    </div>
</div>