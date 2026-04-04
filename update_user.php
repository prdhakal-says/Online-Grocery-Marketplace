<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $user_id = $_GET['id'];
    $action = $_GET['action'];

    // Prevent deleting yourself!
    if ($user_id == $_SESSION['user_id'] && $action == 'delete') {
        $_SESSION['message'] = "You cannot delete your own account!";
        header("Location: admin_manage_user.php");
        exit();
    }

    if ($action == 'toggle') {
        
        $query = "UPDATE users SET is_admin = 1 - is_admin WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $_SESSION['message'] = "User role updated.";
    } 
    elseif ($action == 'delete') {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $_SESSION['message'] = "User removed from system.";
    }
}

header("Location: admin_manage_user.php");
exit();