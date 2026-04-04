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

$query = "SELECT c.id AS cart_id, p.name, p.price, p.image_url, c.quantity FROM cart c 
          JOIN products p ON c.product_id = p.id 
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container my-5">
    <h2 class="mb-4">Shopping Cart</h2>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped align-middle shadow-sm">
            <thead class="table-success text-center">
                <tr>
                    <th width="10%">Image</th>
                    <th width="35%">Name</th>
                    <th width="15%">Price</th>
                    <th width="15%">Quantity</th> <th width="15%">Subtotal</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($item = $result->fetch_assoc()): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total_price += $subtotal; 
                ?>
                    <tr>
                        <td class="text-center">
                            <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>" class="img-fluid" style="max-height: 50px;">
                        </td>
                        <td><?php echo $item['name']; ?></td>
                        <td class="text-center">$<?php echo number_format($item['price'], 2); ?></td>
                        
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="update_cart.php?id=<?php echo $item['cart_id']; ?>&action=decrease" 
                                   class="btn btn-outline-secondary btn-sm px-2 py-0">-</a>
                                
                                <span class="mx-3 fw-bold"><?php echo $item['quantity']; ?></span>
                                
                  <a href="update_cart.php?id=<?php echo $item['cart_id']; ?>&action=increase" 
                                   class="btn btn-outline-secondary btn-sm px-2 py-0">+</a>
                            </div>
                        </td>

                        <td class="text-center">$<?php echo number_format($subtotal, 2); ?></td>
                        
                       <td class="text-center">
    <a href="update_cart.php?id=<?php echo $item['cart_id']; ?>&action=remove" 
       class="btn btn-danger btn-sm">
        <i class="fa-solid fa-trash"></i>
    </a>
</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="row mt-4">
            <div class="col-md-6 offset-md-6 text-end">
                <div class="card p-3 shadow-sm border-success">
                    <h4>Total: <span class="text-success">$<?php echo number_format($total_price, 2); ?></span></h4>
                    <a href="checkout.php" class="btn btn-success btn-lg w-100 mt-3">Proceed to Checkout</a>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="alert alert-info text-center py-5 shadow-sm">
            <i class="fa-solid fa-cart-shopping fa-3x mb-3"></i>
            <p class="lead">Your cart is currently empty.</p>
            <a href="products.php" class="btn btn-success">Start shopping!</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>