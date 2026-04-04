<?php
include 'config/db.php';
include 'includes/header.php';


if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

// Fetch all products
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-boxes-stacked text-success"></i> Inventory Management</h2>
        <a href="admin_add_product.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add New Product</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="10%">Image</th>
                        <th width="30%">Product Name</th>
                        <th width="15%">Category</th>
                        <th width="10%">Price</th>
                        <th width="10%">Stock</th>
                        <th width="20%" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td>
                                <img src="<?php echo $row['image_url']; ?>" alt="" class="img-thumbnail" style="height: 50px; width: 50px; object-fit: cover;">
                            </td>
                            <td class="fw-bold"><?php echo $row['name']; ?></td>
                            <td><span class="badge bg-info text-dark"><?php echo $row['category']; ?></span></td>
                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                            <td><?php echo $row['stock']; ?></td>
                            <td class="text-center">
                                <a href="admin_edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm me-1">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <a href="admin_delete_product.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this product? This cannot be undone.')">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="admin_dashboard.php" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>