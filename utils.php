<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'administrator';
}

function redirect($location) {
    header("Location: $location");
    exit();
}

function sanitizeInput($input) {
    return htmlspecialchars(strip_tags($input));
}
?>