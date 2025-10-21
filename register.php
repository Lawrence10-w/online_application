<?php
include 'config/database.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nrc_number = sanitizeInput($_POST['nrc_number']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = sanitizeInput($_POST['full_name']);
    $email = sanitizeInput($_POST['email']);
    $phone_number = sanitizeInput($_POST['phone_number']);
    $physical_address = sanitizeInput($_POST['physical_address']);
    
    // Validate passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if NRC already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE nrc_number = ?");
        $stmt->execute([$nrc_number]);
        
        if ($stmt->rowCount() > 0) {
            $error = "NRC number already registered!";
        } else {
            // Insert new student
            $hashed_password = hashPassword($password);
            $stmt = $pdo->prepare("INSERT INTO users (nrc_number, password_hash, full_name, email, phone_number, physical_address, role) VALUES (?, ?, ?, ?, ?, ?, 'student')");
            
            if ($stmt->execute([$nrc_number, $hashed_password, $full_name, $email, $phone_number, $physical_address])) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container">
    <div class="form-container">
        <h2>Student Registration</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>NRC Number *</label>
                <input type="text" name="nrc_number" required>
            </div>
            
            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="full_name" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email">
            </div>
            
            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone_number">
            </div>
            
            <div class="form-group">
                <label>Physical Address</label>
                <textarea name="physical_address" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>Password *</label>
                <input type="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label>Confirm Password *</label>
                <input type="password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</div>
<?php include 'includes/footer.php'; ?>