<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('login.php');
}

// Fetch scholarship details
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM Scholarship WHERE scholarship_id = ?");
    $stmt->execute([$id]);
    $scholarship = $stmt->fetch();
} else {
    redirect('manage_scholarship.php');
}

// Update scholarship
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $name = sanitizeInput($_POST['name']);
    $description = sanitizeInput($_POST['description']);
    $amount = floatval($_POST['amount']);
    $deadline = sanitizeInput($_POST['deadline']);
    $criteria = sanitizeInput($_POST['criteria']);

    $stmt = $pdo->prepare("UPDATE Scholarship SET scholarship_name = ?, description = ?, amount = ?, deadline = ?, criteria = ? WHERE scholarship_id = ?");
    $stmt->execute([$name, $description, $amount, $deadline, $criteria, $id]);

    redirect('manage_scholarship.php'); // Redirect after update
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Scholarship - Edu Africa</title>
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
            max-width: 600px;
            margin: 20px;
        }

        h2 {
            color: #4CAF50;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
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

        a {
            display: block;
            margin-top: 1rem;
            color: #4CAF50;
            text-align: center;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Scholarship</h2>
        
        <form method="POST">
            <input type="text" name="name" placeholder="Scholarship Name" value="<?php echo htmlspecialchars($scholarship['scholarship_name']); ?>" required>
            <textarea name="description" placeholder="Description" required><?php echo htmlspecialchars($scholarship['description']); ?></textarea>
            <input type="number" name="amount" placeholder="Amount" step="0.01" value="<?php echo $scholarship['amount']; ?>" required>
            <input type="date" name="deadline" value="<?php echo htmlspecialchars($scholarship['deadline']); ?>" required>
            <textarea name="criteria" placeholder="Criteria" required><?php echo htmlspecialchars($scholarship['criteria']); ?></textarea>
            <button type="submit" name="update">Update Scholarship</button>
        </form>

        <a href="manage_scholarship.php">Cancel</a>
    </div>
</body>
</html>

