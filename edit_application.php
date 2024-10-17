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

// Fetch the application details
$stmt = $pdo->prepare("SELECT * FROM Application WHERE application_id = ? AND user_id = ?");
$stmt->execute([$application_id, $user_id]);
$application = $stmt->fetch();

if (!$application) {
    redirect('apply_scholarship.php'); // Redirect if application not found or user is not the owner
}

// Fetch available scholarships
$stmt = $pdo->query("SELECT * FROM Scholarship WHERE deadline >= CURDATE()");
$scholarships = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $scholarship_id = sanitizeInput($_POST['scholarship_id']);
    $course = sanitizeInput($_POST['course']);
    $supporting_documents = sanitizeInput($_POST['supporting_documents']);

    try {
        $stmt = $pdo->prepare("UPDATE Application SET scholarship_id = ?, course = ?, supporting_documents = ? WHERE application_id = ?");
        $stmt->execute([$scholarship_id, $course, $supporting_documents, $application_id]);
        $success = "Application updated successfully!";
    } catch (PDOException $e) {
        $error = "An error occurred. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application - Edu Africa</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #121212;
    color: #ffffff;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(145deg, #121212, #1a1a1a);
}

.container {
    background-color: #1e1e1e;
    padding: 2.5rem;
    border-radius: 10px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 800px;
    margin: 20px;
}

h2 {
    color: #4CAF50;
    font-size: 2rem;
    margin-bottom: 1.5rem;
    text-align: center;
}

form {
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
}

select, textarea, input[type="text"] {
    width: 100%;
    padding: 1rem;
    background-color: #2d2d2d;
    border: 2px solid #333;
    border-radius: 8px;
    color: #ffffff;
    font-size: 1rem;
    transition: all 0.3s ease;
}

select:focus, textarea:focus, input[type="text"]:focus {
    outline: none;
    border-color: #4CAF50;
    background-color: #333;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 1rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 0.5rem;
}

button:hover {
    background-color: #45a049;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
}

.error, .success {
    background-color: rgba(255, 87, 87, 0.1);
    color: #ff5757;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    border: 1px solid #ff5757;
    text-align: center;
}

.success {
    background-color: rgba(76, 175, 80, 0.1);
    color: #4CAF50;
    border-color: #4CAF50;
}

a {
    color: #4CAF50;
    text-decoration: none;
    transition: color 0.3s ease;
}

a:hover {
    color: #45a049;
    text-decoration: underline;
}

textarea {
    height: 120px;
}

@media (max-width: 480px) {
    .container {
        margin: 1rem;
        padding: 1.5rem;
    }

    h2 {
        font-size: 1.75rem;
    }
}

</style>
<body>
    <div class="container">
        <h2>Edit Application</h2>
        <?php 
        if (isset($error)) echo "<p class='error'>$error</p>";
        if (isset($success)) echo "<p class='success'>$success</p>";
        ?>
        <form method="POST">
            <select name="scholarship_id" required>
                <option value="">Select a Scholarship</option>
                <?php foreach ($scholarships as $scholarship): ?>
                    <option value="<?php echo $scholarship['scholarship_id']; ?>" <?php echo $application['scholarship_id'] == $scholarship['scholarship_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($scholarship['scholarship_name']); ?> - $<?php echo $scholarship['amount']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <select name="course" required>
                <option value="">Select a Course</option>
                <option value="Computer Science" <?php echo $application['course'] == 'Computer Science' ? 'selected' : ''; ?>>Computer Science</option>
                <option value="Business Administration" <?php echo $application['course'] == 'Business Administration' ? 'selected' : ''; ?>>Business Administration</option>
                <option value="Mechanical Engineering" <?php echo $application['course'] == 'Mechanical Engineering' ? 'selected' : ''; ?>>Mechanical Engineering</option>
                <option value="Psychology" <?php echo $application['course'] == 'Psychology' ? 'selected' : ''; ?>>Psychology</option>
                <option value="Biology" <?php echo $application['course'] == 'Biology' ? 'selected' : ''; ?>>Biology</option>
                <option value="Economics" <?php echo $application['course'] == 'Economics' ? 'selected' : ''; ?>>Economics</option>
                <option value="English Literature" <?php echo $application['course'] == 'English Literature' ? 'selected' : ''; ?>>English Literature</option>
                <option value="Medicine" <?php echo $application['course'] == 'Medicine' ? 'selected' : ''; ?>>Medicine</option>
                <option value="Law" <?php echo $application['course'] == 'Law' ? 'selected' : ''; ?>>Law</option>
                <option value="Architecture" <?php echo $application['course'] == 'Architecture' ? 'selected' : ''; ?>>Architecture</option>
            </select>
            
            <textarea name="supporting_documents" placeholder="Enter links to your supporting documents" required><?php echo htmlspecialchars($application['supporting_documents']); ?></textarea>
            <button type="submit">Update Application</button>
        </form>
        
        <a href="apply_scholarship.php?id=<?php echo $application['application_id']; ?>">Cancel</a>
    </div>
</body>
</html>
