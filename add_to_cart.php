<?php
session_start();
include 'config/db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $quantity = 1;

    // Check if item is already in cart
    $check_query = "SELECT id FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If it exists, just update quantity
        $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ii", $user_id, $product_id);
    } else {
        // If it doesn't exist, insert new row
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    }

 
$stmt->execute();


$_SESSION['message'] = "Success! Item added to your cart.";

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
}
?>