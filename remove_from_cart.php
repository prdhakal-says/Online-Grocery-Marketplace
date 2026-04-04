<?php
session_start();
include 'config/db.php';

// Check if logged in and if a cart_id was provided
if (isset($_SESSION['user_id']) && isset($_GET['id'])) {
    $cart_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];


    $query = "DELETE FROM cart WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
}

// Redirect back to the cart page
header("Location: cart.php");
exit();
?>