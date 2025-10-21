<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get the base URL dynamically
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$current_path = dirname($_SERVER['PHP_SELF']);
if ($current_path !== '/') {
    $base_url .= $current_path;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Application System</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Online Application System</div>
            <div class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span>Welcome, <?php echo $_SESSION['full_name']; ?></span>
                    <a href="dashboard.php">Dashboard</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="index.php">Home</a>
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>