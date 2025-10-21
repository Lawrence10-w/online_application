<?php
include '../includes/auth.php';
include '../config/database.php';
redirectIfNotLoggedIn();
redirectBasedOnRole(['student']);

// Get student's applications
$stmt = $pdo->prepare("
    SELECT a.*, c.course_name, c.course_code 
    FROM applications a 
    JOIN courses c ON a.course_id = c.id 
    WHERE a.student_id = ? 
    ORDER BY a.application_date DESC
");
$stmt->execute([$_SESSION['user_id']]);
$applications = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<div class="container">
    <h2>My Applications</h2>
    
    <?php if (empty($applications)): ?>
        <p>You haven't submitted any applications yet. <a href="apply.php">Apply for a course</a></p>
    <?php else: ?>
        <div class="applications-list">
            <?php foreach ($applications as $app): ?>
                <div class="application-card">
                    <h3><?php echo $app['course_name']; ?> (<?php echo $app['course_code']; ?>)</h3>
                    <p><strong>Status:</strong> 
                        <span class="status-<?php echo $app['status']; ?>">
                            <?php echo ucfirst(str_replace('_', ' ', $app['status'])); ?>
                        </span>
                    </p>
                    <p><strong>Application Date:</strong> <?php echo date('M j, Y', strtotime($app['application_date'])); ?></p>
                    
                    <?php if ($app['status'] == 'accepted'): ?>
                        <div class="alert alert-success">
                            Congratulations! Your application has been accepted.
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>