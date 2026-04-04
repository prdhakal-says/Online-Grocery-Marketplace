<?php 
session_start();
include 'config/db.php';
include 'includes/header.php';

$limit = 24; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';


$query = "SELECT * FROM products WHERE 1=1";

if ($search != '') {
    $query .= " AND name LIKE '%$search%'";
}
if ($category != '') {
    $query .= " AND category = '$category'";
}

// 3. Apply Sorting Logic
if ($sort == 'price_low') {
    $query .= " ORDER BY price ASC";
} elseif ($sort == 'price_high') {
    $query .= " ORDER BY price DESC";
} else {
    $query .= " ORDER BY id DESC"; // Default: Show newest first
}

// 4. Get total count for pagination links
$all_results = mysqli_query($conn, $query);
$total_results = mysqli_num_rows($all_results);
$total_pages = ceil($total_results / $limit);

// 5. Add Limit for the current page view
$query .= " LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Our Products</h2>

    <div class="row justify-content-center mb-4">
        <div class="col-md-10">
            <form action="products.php" method="GET" class="row g-2">
                <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search for groceries..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="col-md-4">
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="">Sort By (Default)</option>
                        <option value="price_low" <?php echo ($sort == 'price_low') ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo ($sort == 'price_high') ? 'selected' : ''; ?>>Price: High to Low</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mb-5">
        <a href="products.php?sort=<?php echo $sort; ?>" class="btn btn-outline-success btn-sm me-2 <?php echo ($category == '') ? 'active' : ''; ?>">All</a>
        <a href="products.php?category=Fruits&sort=<?php echo $sort; ?>" class="btn btn-outline-success btn-sm me-2 <?php echo ($category == 'Fruits') ? 'active' : ''; ?>">Fruits</a>
        <a href="products.php?category=Vegetables&sort=<?php echo $sort; ?>" class="btn btn-outline-success btn-sm me-2 <?php echo ($category == 'Vegetables') ? 'active' : ''; ?>">Vegetables</a>
        <a href="products.php?category=Dairy&sort=<?php echo $sort; ?>" class="btn btn-outline-success btn-sm me-2 <?php echo ($category == 'Dairy') ? 'active' : ''; ?>">Dairy</a>
    </div>

    <div class="row">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm border-0 d-flex flex-column">
                        <div style="height: 180px; display: flex; align-items: center; justify-content: center; padding: 15px;">
                            <img src="<?php echo $row['image_url']; ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;" alt="<?php echo $row['name']; ?>">
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text text-success fw-bold mb-auto">$<?php echo number_format($row['price'], 2); ?></p>
                            <a href="add_to_cart.php?id=<?php echo $row['id']; ?>" class="btn btn-success w-100 mt-3">Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="lead text-muted">No products found matching your selection.</p>
                <a href="products.php" class="btn btn-link text-success">Clear all filters</a>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($total_pages > 1): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mt-4">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link text-success" href="products.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category); ?>&sort=<?php echo $sort; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>