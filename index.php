<?php 

session_start(); 

include 'includes/header.php'; 
?>

<section class="hero text-center text-white d-flex align-items-center" style="background: url('images/grocery.jpg') no-repeat center center/cover; height: 400px;">
  <div class="container">
    <h1 class="display-4 fw-bold shadow-text">Fresh Groceries Delivered</h1>
    <p class="lead">Fruits, Vegetables, Dairy & More</p>
    <a href="products.php" class="btn btn-light btn-lg">Shop Now</a>
  </div>
</section>

<section class="container my-5">
  <h2 class="text-center mb-4">Featured Products</h2>
  <div class="row">
    <?php
    include 'config/db.php';
    
    $query = "SELECT * FROM products LIMIT 4";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
    ?>
      <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm border-0 d-flex flex-column">
          
          <div style="height: 180px; display: flex; align-items: center; justify-content: center; padding: 15px;">
             <img src="<?php echo $row['image_url']; ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;" alt="<?php echo $row['name']; ?>">
          </div>
          
          <div class="card-body text-center d-flex flex-column">
            <h5 class="card-title"><?php echo $row['name']; ?></h5>
            <p class="card-text text-success fw-bold mb-auto">$<?php echo number_format($row['price'], 2); ?></p>
            
            <a href="add_to_cart.php?id=<?php echo $row['id']; ?>" class="btn btn-success w-100 mt-3">
                Add to Cart
            </a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</section>

<?php include 'includes/footer.php'; ?>