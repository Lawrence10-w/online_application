<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: ../login.php");
        exit();
    }
}

function redirectBasedOnRole($allowed_roles) {
    if (!isLoggedIn() || !in_array($_SESSION['role'], $allowed_roles)) {
        header("Location: ../dashboard.php");
        exit();
    }
}
?>