<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn() || isAdmin()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];

// Fetch available scholarships
$stmt = $pdo->query("SELECT * FROM Scholarship WHERE deadline >= CURDATE()");
$scholarships = $stmt->fetchAll();

// Example courses
$courses = [
    'Computer Science',
    'Business Administration',
    'Mechanical Engineering',
    'Psychology',
    'Biology',
    'Economics',
    'English Literature',
    'Medicine',
    'Law',
    'Architecture'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $scholarship_id = sanitizeInput($_POST['scholarship_id']);
    $course = sanitizeInput($_POST['course']);
    $supporting_documents = sanitizeInput($_POST['supporting_documents']);

    try {
        $stmt = $pdo->prepare("INSERT INTO Application (user_id, scholarship_id, course, submission_date, supporting_documents) VALUES (?, ?, ?, CURDATE(), ?)");
        $stmt->execute([$user_id, $scholarship_id, $course, $supporting_documents]);
        $success = "Application submitted successfully!";
    } catch (PDOException $e) {
        $error = "An error occurred. Please try again.";
    }
}

// Fetch user's applications
$stmt = $pdo->prepare("SELECT a.*, s.scholarship_name FROM Application a JOIN Scholarship s ON a.scholarship_id = s.scholarship_id WHERE a.user_id = ?");
$stmt->execute([$user_id]);
$applications = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Scholarship - Edu Africa</title>
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

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 2rem;
    background-color: #2d2d2d;
}

table th, table td {
    padding: 1rem;
    text-align: left;
    border: 1px solid #333;
    color: #ffffff;
}

table th {
    background-color: #4CAF50;
}

table tr:nth-child(even) {
    background-color: #1e1e1e;
}

table tr:hover {
    background-color: #333;
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
        <h2>Apply for Scholarship</h2>
        <?php 
        if (isset($error)) echo "<p class='error'>$error</p>";
        if (isset($success)) echo "<p class='success'>$success</p>";
        ?>
        <form method="POST">
            <select name="scholarship_id" required>
                <option value="">Select a Scholarship</option>
                <?php foreach ($scholarships as $scholarship): ?>
                    <option value="<?php echo $scholarship['scholarship_id']; ?>">
                        <?php echo htmlspecialchars($scholarship['scholarship_name']); ?> - $<?php echo $scholarship['amount']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <select name="course" required>
                <option value="">Select a Course</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?php echo $course; ?>"><?php echo $course; ?></option>
                <?php endforeach; ?>
            </select>
            
            <textarea name="supporting_documents" placeholder="Enter links to your supporting documents" required></textarea>
            <button type="submit">Submit Application</button>
        </form>

        <h2>Your Applications</h2>
        <table>
            <tr>
                <th>Scholarship</th>
                <th>Course</th>
                <th>Submission Date</th>
                <th>Supporting Documents</th>
                <th>Action</th>
            </tr>
            <?php foreach ($applications as $application): ?>
            <tr>
                <td><?php echo htmlspecialchars($application['scholarship_name']); ?></td>
                <td><?php echo htmlspecialchars($application['course']); ?></td>
                <td><?php echo htmlspecialchars($application['submission_date']); ?></td>
                <td><?php echo htmlspecialchars($application['supporting_documents']); ?></td>
                <td>
                    <a href="view_app.php?id=<?php echo $application['application_id']; ?>">View</a> |
                    <a href="edit_application.php?id=<?php echo $application['application_id']; ?>">Edit</a> |
                    <a href="delete_application.php?id=<?php echo $application['application_id']; ?>" onclick="return confirm('Are you sure you want to delete this application?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
