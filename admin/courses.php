<?php
include '../includes/auth.php';
include '../config/database.php';
include '../includes/functions.php';
redirectIfNotLoggedIn();
redirectBasedOnRole(['admin']);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_course'])) {
        $course_code = sanitizeInput($_POST['course_code']);
        $course_name = sanitizeInput($_POST['course_name']);
        $description = sanitizeInput($_POST['description']);
        $hod_id = $_POST['hod_id'];
        
        $stmt = $pdo->prepare("INSERT INTO courses (course_code, course_name, description, hod_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$course_code, $course_name, $description, $hod_id]);
        $success = "Course added successfully!";
    }
    
    if (isset($_POST['add_subject'])) {
        $subject_code = sanitizeInput($_POST['subject_code']);
        $subject_name = sanitizeInput($_POST['subject_name']);
        $course_id = $_POST['course_id'];
        
        $stmt = $pdo->prepare("INSERT INTO subjects (subject_code, subject_name, course_id) VALUES (?, ?, ?)");
        $stmt->execute([$subject_code, $subject_name, $course_id]);
        $success = "Subject added successfully!";
    }
}

// Get data for dropdowns
$courses = $pdo->query("SELECT * FROM courses")->fetchAll();
$hods = $pdo->query("SELECT * FROM users WHERE role = 'hod'")->fetchAll();
$subjects = $pdo->query("SELECT s.*, c.course_name FROM subjects s JOIN courses c ON s.course_id = c.id")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management - Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        header {
            background: #2c3e50;
            color: white;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        h1, h2, h3 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        /* Forms */
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .alert-error {
            background: #e74c3c;
            color: white;
        }

        .alert-success {
            background: #27ae60;
            color: white;
        }

        /* Admin sections */
        .admin-sections {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .admin-section {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Tables */
        .data-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-top: 1rem;
        }

        .data-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .data-table th {
            background: #34495e;
            color: white;
            font-weight: bold;
        }

        .data-table tr:hover {
            background: #f8f9fa;
        }

        /* Cards */
        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Online Application System</div>
            <div class="nav-links">
                <span>Welcome, <?php echo $_SESSION['full_name']; ?></span>
                <a href="../dashboard.php">Dashboard</a>
                <a href="../logout.php">Logout</a>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1>Course and Subject Management</h1>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="admin-sections">
            <!-- Add Course Section -->
            <div class="admin-section">
                <h3>Add New Course</h3>
                <form method="POST" action="">
                    <input type="hidden" name="add_course" value="1">
                    <div class="form-group">
                        <label>Course Code</label>
                        <input type="text" name="course_code" required>
                    </div>
                    <div class="form-group">
                        <label>Course Name</label>
                        <input type="text" name="course_name" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Head of Department</label>
                        <select name="hod_id" required>
                            <option value="">Select HOD</option>
                            <?php foreach ($hods as $hod): ?>
                                <option value="<?php echo $hod['id']; ?>"><?php echo $hod['full_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Course</button>
                </form>
            </div>
            
            <!-- Add Subject Section -->
            <div class="admin-section">
                <h3>Add New Subject</h3>
                <form method="POST" action="">
                    <input type="hidden" name="add_subject" value="1">
                    <div class="form-group">
                        <label>Subject Code</label>
                        <input type="text" name="subject_code" required>
                    </div>
                    <div class="form-group">
                        <label>Subject Name</label>
                        <input type="text" name="subject_name" required>
                    </div>
                    <div class="form-group">
                        <label>Course</label>
                        <select name="course_id" required>
                            <option value="">Select Course</option>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?php echo $course['id']; ?>"><?php echo $course['course_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Subject</button>
                </form>
            </div>
        </div>
        
        <!-- Existing Courses -->
        <div class="admin-section">
            <h3>Existing Courses</h3>
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>HOD</th>
                            <th>Subjects</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><?php echo $course['course_code']; ?></td>
                                <td><?php echo $course['course_name']; ?></td>
                                <td>
                                    <?php 
                                    if ($course['hod_id']) {
                                        $hod_stmt = $pdo->prepare("SELECT full_name FROM users WHERE id = ?");
                                        $hod_stmt->execute([$course['hod_id']]);
                                        $hod = $hod_stmt->fetch();
                                        echo $hod ? $hod['full_name'] : 'Not assigned';
                                    } else {
                                        echo 'Not assigned';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $subject_count = $pdo->prepare("SELECT COUNT(*) FROM subjects WHERE course_id = ?");
                                    $subject_count->execute([$course['id']]);
                                    echo $subject_count->fetchColumn();
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>