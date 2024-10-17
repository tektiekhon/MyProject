<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn() || isAdmin()) {
    redirect('login.php');
}

if (!isset($_GET['id'])) {
    redirect('apply_scholarship.php'); // Redirect if no ID is provided
}

$application_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Check if the application exists and belongs to the user
$stmt = $pdo->prepare("SELECT * FROM Application WHERE application_id = ? AND user_id = ?");
$stmt->execute([$application_id, $user_id]);
$application = $stmt->fetch();

if ($application) {
    // Delete the application
    $stmt = $pdo->prepare("DELETE FROM Application WHERE application_id = ?");
    $stmt->execute([$application_id]);
    redirect('apply_scholarship.php'); // Redirect after deletion
} else {
    redirect('apply_scholarship.php'); // Redirect if application not found or user is not the owner
}
