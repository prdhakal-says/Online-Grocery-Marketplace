<?php
include 'config/db.php';
include 'includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 1. Fetch cart items
$cart_query = "SELECT c.*, p.price FROM cart c 
               JOIN products p ON c.product_id = p.id 
               WHERE c.user_id = ?";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();

if ($cart_result->num_rows > 0) {
    // 2. Calculate Total
    $total_price = 0;
    $items = [];
    while ($row = $cart_result->fetch_assoc()) {
        $total_price += $row['price'] * $row['quantity'];
        $items[] = $row;
    }

    // 3. Insert into 'orders' table
    $order_sql = "INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'Paid')";
    $order_stmt = $conn->prepare($order_sql);
    $order_stmt->bind_param("id", $user_id, $total_price);
    $order_stmt->execute();
    $order_id = $conn->insert_id; 

    // 4. Insert items into 'order_items' table
    $item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $item_stmt = $conn->prepare($item_sql);

    foreach ($items as $item) {
        $item_stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $item_stmt->execute();
    }

    // 5. Clear the cart
    $clear_sql = "DELETE FROM cart WHERE user_id = ?";
    $clear_stmt = $conn->prepare($clear_sql);
    $clear_stmt->bind_param("i", $user_id);
    $clear_stmt->execute();

    // 6. Success! Redirect to Invoice
    echo "<script>window.location.href='invoice.php?id=$order_id';</script>";

} else {
    echo "<div class='container mt-5'><div class='alert alert-warning'>Your cart is empty!</div></div>";
}

include 'includes/footer.php';
?>