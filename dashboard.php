<?php
include 'includes/auth.php';
redirectIfNotLoggedIn();
?>
<?php include 'includes/header.php'; ?>
<div class="container">
    <h1>Welcome, <?php echo $_SESSION['full_name']; ?>!</h1>
    <p>Role: <?php echo ucfirst($_SESSION['role']); ?></p>
    
    <div class="dashboard-cards">
        <?php if ($_SESSION['role'] == 'student'): ?>
            <div class="card">
                <h3>My Applications</h3>
                <p>View and manage your course applications</p>
                <a href="student/applications.php" class="btn btn-primary">View Applications</a>
            </div>
            <div class="card">
                <h3>Apply for Course</h3>
                <p>Submit new course application</p>
                <a href="student/apply.php" class="btn btn-primary">Apply Now</a>
            </div>
            
        <?php elseif ($_SESSION['role'] == 'lecturer'): ?>
            <div class="card">
                <h3>My Subjects</h3>
                <p>Manage subjects and students</p>
                <a href="lecturer/subjects.php" class="btn btn-primary">View Subjects</a>
            </div>
            
        <?php elseif ($_SESSION['role'] == 'hod'): ?>
            <div class="card">
                <h3>Course Management</h3>
                <p>Manage course applications and students</p>
                <a href="hod/courses.php" class="btn btn-primary">Manage Course</a>
            </div>
            
        <?php elseif ($_SESSION['role'] == 'admin'): ?>
            <div class="card">
                <h3>System Management</h3>
                <p>Manage courses, subjects, and users</p>
                <a href="admin/courses.php" class="btn btn-primary">Manage System</a>
            </div>
            
        <?php elseif ($_SESSION['role'] == 'accountant'): ?>
            <div class="card">
                <h3>Payment Verification</h3>
                <p>Verify student payments</p>
                <a href="accountant/payments.php" class="btn btn-primary">View Payments</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>