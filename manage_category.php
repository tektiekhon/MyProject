<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('login.php');
}

// Add new category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name = sanitizeInput($_POST['name']);
    $description = sanitizeInput($_POST['description']);

    $stmt = $pdo->prepare("INSERT INTO Category (category_name, description) VALUES (?, ?)");
    $stmt->execute([$name, $description]);
}

// Delete category
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM Category WHERE category_id = ?");
    $stmt->execute([$id]);
}

// Fetch all categories
$stmt = $pdo->query("SELECT * FROM Category");
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Edu Africa</title>
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
        <h2>Categories</h2>
        
        <h3>Add New Category</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Category Name" required>
            <textarea name="description" placeholder="Description"></textarea>
            <button type="submit" name="add">Add Category</button>
        </form>

        <h3>Existing Categories</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                <td><?php echo htmlspecialchars($category['description']); ?></td>
                <td>
                    <a href="view_category.php?id=<?php echo $category['category_id']; ?>">View</a> |
                    <a href="edit_category.php?id=<?php echo $category['category_id']; ?>">Edit</a> |
                    <a href="?delete=<?php echo $category['category_id']; ?>" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <a href="dashboard.php" class="button">Back to Dashboard</a>
    </div>
</body>
</html>

