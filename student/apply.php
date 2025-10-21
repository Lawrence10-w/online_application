<?php
include '../includes/auth.php';
include '../config/database.php';
include '../includes/functions.php';
redirectIfNotLoggedIn();
redirectBasedOnRole(['student']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'];
    $subjects = $_POST['subjects'];
    $grades = $_POST['grades'];
    
    try {
        $pdo->beginTransaction();
        
        // Check if already applied
        $stmt = $pdo->prepare("SELECT id FROM applications WHERE student_id = ? AND course_id = ?");
        $stmt->execute([$_SESSION['user_id'], $course_id]);
        
        if ($stmt->rowCount() > 0) {
            $error = "You have already applied for this course!";
        } else {
            // Create application
            $stmt = $pdo->prepare("INSERT INTO applications (student_id, course_id) VALUES (?, ?)");
            $stmt->execute([$_SESSION['user_id'], $course_id]);
            $application_id = $pdo->lastInsertId();
            
            // Add subjects
            $stmt = $pdo->prepare("INSERT INTO application_subjects (application_id, subject_name, grade) VALUES (?, ?, ?)");
            for ($i = 0; $i < count($subjects); $i++) {
                if (!empty($subjects[$i]) && !empty($grades[$i])) {
                    $stmt->execute([$application_id, $subjects[$i], $grades[$i]]);
                }
            }
            
            // Handle file uploads
            $uploaded_files = [];
            $document_types = ['certified_results', 'nrc_copy', 'address_proof'];
            
            foreach ($document_types as $doc_type) {
                if (isset($_FILES[$doc_type]) && $_FILES[$doc_type]['error'] == 0) {
                    $file_path = handleFileUpload($_FILES[$doc_type]);
                    if ($file_path) {
                        $stmt = $pdo->prepare("INSERT INTO documents (application_id, document_type, file_path, original_file_name) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$application_id, $doc_type, $file_path, $_FILES[$doc_type]['name']]);
                    }
                }
            }
            
            $pdo->commit();
            $success = "Application submitted successfully!";
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Application failed: " . $e->getMessage();
    }
}

// Get available courses
$courses = $pdo->query("SELECT * FROM courses WHERE is_active = TRUE")->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<div class="container">
    <h2>Apply for Course</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label>Select Course *</label>
            <select name="course_id" required>
                <option value="">Choose a course</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?php echo $course['id']; ?>"><?php echo $course['course_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Best Five Subjects & Grades *</label>
            <div id="subjects-container">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <div class="subject-row">
                        <input type="text" name="subjects[]" placeholder="Subject <?php echo $i; ?>" required>
                        <input type="text" name="grades[]" placeholder="Grade <?php echo $i; ?>" required>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
        
        <div class="form-group">
            <label>Certified Results (PDF) *</label>
            <input type="file" name="certified_results" accept=".pdf" required>
        </div>
        
        <div class="form-group">
            <label>NRC Copy (PDF/Image) *</label>
            <input type="file" name="nrc_copy" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>
        
        <div class="form-group">
            <label>Address Proof (PDF/Image) *</label>
            <input type="file" name="address_proof" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>