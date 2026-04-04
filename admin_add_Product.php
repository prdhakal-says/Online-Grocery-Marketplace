<?php
include 'config/db.php';
include 'includes/header.php';


if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

$message = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);

    
    $query = "INSERT INTO products (name, description, price, category, stock, image_url) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdsss", $name, $description, $price, $category, $stock, $image_url);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Product added successfully! <a href='products.php' class='alert-link'>View it here</a></div>";
    } else {
        $message = "<div class='alert alert-danger'>Error adding product: " . $conn->error . "</div>";
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white py-3">
                    <h4 class="mb-0"><i class="fa-solid fa-plus-circle"></i> Add New Product</h4>
                </div>
                <div class="card-body p-4">
                    
                    <?php echo $message; ?>

                    <form action="admin_add_product.php" method="POST">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Product Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Organic Apples" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <option value="Fruits">Fruits</option>
                                    <option value="Vegetables">Vegetables</option>
                                    <option value="Dairy">Dairy</option>
                                    <option value="Bakery">Bakery</option>
                                    <option value="Electronics">Electronics</option> </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Stock Qty</label>
                                <input type="number" name="stock" class="form-control" value="10" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Image URL Path</label>
                                <input type="text" name="image_url" class="form-control" placeholder="images/filename.png" required>
                                <small class="text-muted">Ensure the file exists in your <strong>images/</strong> folder.</small>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Tell users about this item..."></textarea>
                            </div>

                            <div class="col-md-12 d-flex gap-2">
                                <button type="submit" class="btn btn-success flex-grow-1">Save Product</button>
                                <a href="admin_dashboard.php" class="btn btn-outline-secondary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>