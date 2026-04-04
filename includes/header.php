<?php
// Ensure session starts before any HTML is sent
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛒 Grocery Store</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🛒 Grocery Store</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    
                    <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link text-warning fw-bold border border-warning rounded px-2 ms-lg-2" href="admin_dashboard.php">
                                <i class="fa-solid fa-user-shield"></i> Admin Panel
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item"><a class="nav-link" href="order_history.php">My Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart <i class="fa-solid fa-cart-shopping"></i></a></li>
                    
                    <li class="nav-item ms-lg-3">
                        <span class="nav-link text-white fw-bold">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm ms-lg-2 text-success fw-bold" href="logout.php">Logout</a>
                    </li>

                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart <i class="fa-solid fa-cart-shopping"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm ms-lg-2 text-success fw-bold" href="register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<?php if (isset($_SESSION['message'])): ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check"></i> <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>