<?php
include 'config/db.php';
include 'includes/header.php';


if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

// Fetch all users
$query = "SELECT id, name, email, is_admin FROM users ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-users-gear text-warning"></i> User Management</h2>
        <a href="admin_dashboard.php" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-warning text-dark">
                    <tr>
                        <th width="10%">User ID</th>
                        <th width="30%">Full Name</th>
                        <th width="30%">Email Address</th>
                        <th width="15%">Role</th>
                        <th width="15%" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <?php if ($row['is_admin'] == 1): ?>
                                    <span class="badge bg-danger">Admin</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Customer</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="update_user.php?id=<?php echo $row['id']; ?>&action=toggle" 
                                   class="btn btn-sm <?php echo $row['is_admin'] == 1 ? 'btn-outline-secondary' : 'btn-outline-danger'; ?>"
                                   title="Change Role">
                                    <i class="fa-solid fa-user-shield"></i>
                                </a>

                                <?php if ($row['id'] != $_SESSION['user_id']): ?>
                                    <a href="update_user.php?id=<?php echo $row['id']; ?>&action=delete" 
                                       class="btn btn-outline-dark btn-sm ms-1" 
                                       onclick="return confirm('Permanently delete this user?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>