<?php
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

function handleFileUpload($file, $upload_dir = '../uploads/') {
    $filename = uniqid() . '_' . basename($file['name']);
    $target_path = $upload_dir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return $filename;
    }
    return false;
}
?>