<?php
include('config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $name, $email, $password);

  if ($stmt->execute()) {
    echo "<script>alert('Registered Successfully'); window.location='login.php';</script>";
  } else {
    echo "Error: " . $stmt->error;
  }
}
?>

<?php include('includes/header.php'); ?>

<div class="container my-5">
  <h2>Register</h2>

  <form method="POST">
    <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
    <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

    <button class="btn btn-success">Register</button>
  </form>
</div>

<?php include('includes/footer.php'); ?>