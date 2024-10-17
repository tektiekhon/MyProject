<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM Registration WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Counts for various elements
$total_categories = $pdo->query("SELECT COUNT(*) FROM Category")->fetchColumn();
$total_users = $pdo->query("SELECT COUNT(*) FROM Registration")->fetchColumn();
$total_applications = $pdo->query("SELECT COUNT(*) FROM Application")->fetchColumn();
$total_scholarships = $pdo->query("SELECT COUNT(*) FROM Scholarship")->fetchColumn();

if (isAdmin()) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM Application WHERE application_status = 'pending'");
    $pending_applications = $stmt->fetchColumn();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Edu Africa</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    /* Base styles */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #0a0a0a;
    color: #e0e0e0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.container {
    width: 95%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    flex-grow: 1;
}

/* Header styles */
header {
    background-color: #1a1a1a;
    color: #ffffff;
    padding: 20px;
    border-radius: 10px 10px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

header h1 {
    margin: 0;
    font-size: 24px;
    color: #4CAF50;
}

.logout-btn {
    background-color: #4CAF50;
    color: #ffffff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s, transform 0.3s;
}

.logout-btn:hover {
    background-color: #45a049;
    transform: translateY(-2px);
}

/* Navigation styles */
.nav-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    padding: 20px 0;
}

.nav-tabs a {
    flex: 1;
    text-align: center;
    padding: 12px;
    color: #ffffff;
    text-decoration: none;
    border-radius: 5px;
    transition: transform 0.3s, box-shadow 0.3s;
    font-weight: bold;
    background-color: #2a2a2a;
}

.nav-tabs a:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    background-color: #4CAF50;
}

/* Main content styles */
main {
    background-color: #1a1a1a;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

main h2 {
    color: #4CAF50;
    border-bottom: 2px solid #333333;
    padding-bottom: 10px;
    margin-top: 0;
}

/* Dashboard grid styles */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.dashboard-item {
    background-color: #2a2a2a;
    color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.dashboard-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
    background-color: #4CAF50;
}

.dashboard-item h3 {
    margin: 0;
    font-size: 18px;
}

.dashboard-number {
    font-size: 36px;
    font-weight: bold;
    margin: 10px 0 0 0;
    color: #4CAF50;
}

/* Footer styles */
footer {
    text-align: center;
    padding: 20px;
    color: #999999;
    background-color: #1a1a1a;
    margin-top: 20px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .nav-tabs {
        flex-direction: column;
    }
    
    .nav-tabs a {
        width: 100%;
    }
    
    .dashboard-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<body>
    <div class="container">
        <header>
            <h1>Edu Africa</h1>
            <p> <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
            <a href="logout.php" class="logout-btn">Logout</a>
        </header>

        <nav class="nav-tabs">
            <?php if (isAdmin()): ?>
                <a href="manage_scholarship.php">Scholarships</a>
                <a href="manage_category.php">Categories</a>
                <a href="manage_users.php">Users</a>
                <a href="view_applications.php">View Applications</a>
            <?php else: ?>
                <a href="apply_scholarship.php">Apply for Scholarship</a>
                <a href="user_profile.php">View/Edit Profile</a>
            <?php endif; ?>
        </nav>

        <main>
            <h2><?php echo isAdmin() ? 'Administrator Dashboard' : 'Student Dashboard'; ?></h2>
            <div class="dashboard-grid">
                <?php if (isAdmin()): ?>
                    <div class="dashboard-item">
                        <h3>Pending Applications</h3>
                        <p class="dashboard-number"><?php echo $pending_applications; ?></p>
                    </div>
                    <div class="dashboard-item">
                        <h3>Total Categories</h3>
                        <p class="dashboard-number"><?php echo $total_categories; ?></p>
                    </div>
                    <div class="dashboard-item">
                        <h3>Total Users</h3>
                        <p class="dashboard-number"><?php echo $total_users; ?></p>
                    </div>
                    <div class="dashboard-item">
                        <h3>Total Applications</h3>
                        <p class="dashboard-number"><?php echo $total_applications; ?></p>
                    </div>
                    <div class="dashboard-item">
                        <h3>Total Scholarships</h3>
                        <p class="dashboard-number"><?php echo $total_scholarships; ?></p>
                    </div>
                <?php else: ?>
                    <div class="dashboard-item">
                        <h3>Available Scholarships</h3>
                        <p class="dashboard-number"><?php echo $total_scholarships; ?></p>
                    </div>
                    <div class="dashboard-item">
                        <h3>My Applications</h3>
                        <p class="dashboard-number"><?php echo $total_applications; ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <footer>
            <p>&copy; 2024 Edu Africa</p>
        </footer>
    </div>
</body>
</html>
