<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config/db.php');

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password, is_admin FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // 2. Verify Password
        if (password_verify($password, $user['password'])) {
            // 3. Set Session Variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name']; // Using 'name' to match your DB
            $_SESSION['is_admin'] = $user['is_admin']; 

            // 4. Redirect based on role
            if ($_SESSION['is_admin'] == 1) {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid Password');</script>";
        }
    } else {
        echo "<script>alert('No user found with that email');</script>";
    }
}
?>

<?php include('includes/header.php'); ?>

<div class="container my-5" style="max-width: 400px;">
    <div class="card p-4 shadow-sm border-0">
        <h2 class="text-center mb-4">Login</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button class="btn btn-success w-100 py-2 fw-bold">Login</button>
        </form>
        <p class="mt-3 text-center small text-muted">
            Don't have an account? <a href="register.php" class="text-success text-decoration-none fw-bold">Register here</a>
        </p>
    </div>
</div>

<?php include('includes/footer.php'); ?>