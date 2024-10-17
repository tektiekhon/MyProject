<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('login.php');
}

// Add new scholarship
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name = sanitizeInput($_POST['name']);
    $description = sanitizeInput($_POST['description']);
    $amount = floatval($_POST['amount']);
    $deadline = sanitizeInput($_POST['deadline']);
    $criteria = sanitizeInput($_POST['criteria']);

    $stmt = $pdo->prepare("INSERT INTO Scholarship (scholarship_name, description, amount, deadline, criteria) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $amount, $deadline, $criteria]);
}

// Delete scholarship
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM Scholarship WHERE scholarship_id = ?");
    $stmt->execute([$id]);
}

// Fetch all scholarships
$stmt = $pdo->query("SELECT * FROM Scholarship");
$scholarships = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarships - Edu Africa</title>
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

        h3 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            color: #ffffff;
        }

        form {
            margin-bottom: 2rem;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #2a2a2a;
            color: #ffffff;
        }

        button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: #ffffff;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #444;
        }

        th {
            background-color: #333;
        }

        tr:hover {
            background-color: #2a2a2a;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .button {
            display: inline-block;
            margin-top: 1rem;
            color: #4CAF50;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Scholarships</h2>
        
        <h3>Add New Scholarship</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Scholarship Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="number" name="amount" placeholder="Amount" step="0.01" required>
            <input type="date" name="deadline" required>
            <textarea name="criteria" placeholder="Criteria" required></textarea>
            <button type="submit" name="add">Add Scholarship</button>
        </form>

        <h3>Existing Scholarships</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Amount</th>
                <th>Deadline</th>
                <th>Action</th>
            </tr>
            <?php foreach ($scholarships as $scholarship): ?>
            <tr>
                <td><?php echo htmlspecialchars($scholarship['scholarship_name']); ?></td>
                <td>$<?php echo $scholarship['amount']; ?></td>
                <td><?php echo $scholarship['deadline']; ?></td>
                <td>
                    <a href="view_scholarship.php?id=<?php echo $scholarship['scholarship_id']; ?>">View</a>
                    <a href="edit_scholarship.php?id=<?php echo $scholarship['scholarship_id']; ?>">Edit</a>
                    <a href="?delete=<?php echo $scholarship['scholarship_id']; ?>" onclick="return confirm('Are you sure you want to delete this scholarship?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <a href="dashboard.php" class="button">Back to Dashboard</a>
    </div>
</body>
</html>

