<?php
include 'config/db.php';
include 'includes/header.php';


if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}


$res_p = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$total_products = mysqli_fetch_assoc($res_p)['total'];

$res_o = mysqli_query($conn, "SELECT COUNT(*) as total FROM orders");
$total_orders = mysqli_fetch_assoc($res_o)['total'];

// 👥 NEW: Fetch Total Users
$res_u = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$total_users = mysqli_fetch_assoc($res_u)['total'];
?>

<div class="container my-5">
    <h2 class="text-center mb-5"><i class="fa-solid fa-user-shield text-success"></i> Admin Control Center</h2>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 border-top border-4 border-success">
                <div class="card-body text-center p-4">
                    <h1 class="display-4 fw-bold text-dark"><?php echo $total_products; ?></h1>
                    <p class="text-muted text-uppercase small fw-bold">Total Products</p>
                    <div class="d-grid gap-2 mt-3">
                        <a href="admin_manage_products.php" class="btn btn-outline-success">Manage Inventory</a>
                        <a href="admin_add_product.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add New</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 border-top border-4 border-primary">
                <div class="card-body text-center p-4">
                    <h1 class="display-4 fw-bold text-dark"><?php echo $total_orders; ?></h1>
                    <p class="text-muted text-uppercase small fw-bold">Total Orders</p>
                    <div class="d-grid mt-3">
                        <a href="admin_view_orders.php" class="btn btn-primary py-3">
                            <i class="fa-solid fa-list-check"></i> View All Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 border-top border-4 border-warning">
                <div class="card-body text-center p-4">
                    <h1 class="display-4 fw-bold text-dark"><?php echo $total_users; ?></h1>
                    <p class="text-muted text-uppercase small fw-bold">Registered Users</p>
                    <div class="d-grid mt-3">
                        <a href="admin_manage_user.php" class="btn btn-warning py-3 fw-bold text-dark">
                            <i class="fa-solid fa-users-gear"></i> Manage Users
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>