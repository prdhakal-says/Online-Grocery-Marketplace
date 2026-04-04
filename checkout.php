<?php
session_start();
include 'config/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$total_price = 0;

// Fetch cart items from the database
$query = "SELECT p.name, p.price, c.quantity FROM cart c 
          JOIN products p ON c.product_id = p.id 
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container my-5">
    <h2 class="mb-4 text-center">Checkout</h2>
    <form action="place_order.php" method="POST">
        <div class="row">
            <div class="col-md-5 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-success">Your Cart</span>
                </h4>
                <ul class="list-group mb-3 shadow-sm">
                    <?php 
                    if ($result->num_rows > 0):
                        while ($item = $result->fetch_assoc()): 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total_price += $subtotal;
                    ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0"><?php echo $item['name']; ?></h6>
                                <small class="text-muted">Quantity: <?php echo $item['quantity']; ?></small>
                            </div>
                            <span class="text-muted">$<?php echo number_format($subtotal, 2); ?></span>
                        </li>
                    <?php 
                        endwhile; 
                    else: ?>
                        <li class="list-group-item text-center">Your cart is empty</li>
                    <?php endif; ?>
                    
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <span>Total (USD)</span>
                        <strong class="text-success">$<?php echo number_format($total_price, 2); ?></strong>
                    </li>
                </ul>
            </div>

            <div class="col-md-7 order-md-1">
                <div class="card p-4 shadow-sm mb-4">
                    <h4 class="mb-3">Shipping Address</h4>
                    <div class="mb-3">
                        <label for="address">Full Address</label>
                        <input type="text" class="form-control" name="address" placeholder="1234 Main St" required>
                    </div>
                </div>

                <div class="card p-4 shadow-sm">
                    <h4 class="mb-3">Payment Information</h4>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Name on Card</label>
                            <input type="text" class="form-control" name="card_name" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Credit Card Number</label>
                            <input type="text" class="form-control" name="card_number" placeholder="0000 0000 0000 0000" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Expiration (MM/YY)</label>
                            <input type="text" class="form-control" name="expiry" placeholder="12/26" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>CVV</label>
                            <input type="text" class="form-control" name="cvv" placeholder="123" required>
                        </div>
                    </div>
                    
                    <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                    
                    <button class="btn btn-success btn-lg w-100 mt-4" type="submit">Place Order</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>