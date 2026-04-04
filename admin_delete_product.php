<?php
session_start();
include 'config/db.php';

// Security Check
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete the product
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Product deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting product.";
    }
}

header("Location: admin_manage_products.php");
exit();