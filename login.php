<?php
include 'config/database.php';
include 'includes/functions.php';
include 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nrc_number = sanitizeInput($_POST['nrc_number']);
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE nrc_number = ?");
    $stmt->execute([$nrc_number]);
    $user = $stmt->fetch();
    
    if ($user && verifyPassword($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nrc_number'] = $user['nrc_number'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];
        
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid NRC number or password!";
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container">
    <div class="form-container">
        <h2>Login</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>NRC Number</label>
                <input type="text" name="nrc_number" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <p>Don't have an account? <a href="register.php">Register as student</a></p>
    </div>
</div>
<?php include 'includes/footer.php'; ?>