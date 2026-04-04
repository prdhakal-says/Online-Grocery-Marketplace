<?php
session_start();
include 'config/db.php';

if (isset($_GET['id']) && isset($_GET['action'])) {
    $cart_id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'increase') {
        $query = "UPDATE cart SET quantity = quantity + 1 WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
    } 
    elseif ($action == 'decrease') {
        // Only decrease if quantity is more than 1
        $query = "UPDATE cart SET quantity = quantity - 1 WHERE id = ? AND quantity > 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
    } 
    elseif ($action == 'remove') {
        $query = "DELETE FROM cart WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
    }
}

header("Location: cart.php");
exit();