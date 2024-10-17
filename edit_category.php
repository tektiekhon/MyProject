<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('login.php');
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM Category WHERE category_id = ?");
    $stmt->execute([$id]);
    $category = $stmt->fetch();
} else {
    redirect('manage_category.php');
}

// Update category
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitizeInput($_POST['name']);
    $description = sanitizeInput($_POST['description']);

    $stmt = $pdo->prepare("UPDATE Category SET category_name = ?, description = ? WHERE category_id = ?");
    $stmt->execute([$name, $description, $id]);
    redirect('manage_category.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - Edu Africa</title>
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
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 1rem;
            background-color: #2d2d2d;
            border: 2px solid #333;
            border-radius: 8px;
            color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, textarea:focus {
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
        }

        button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            display: inline-block;
            margin-top: 1rem;
        }

        a:hover {
            color: #45a049;
            text-decoration: underline;
        }

        textarea {
            height: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Category</h2>
        <form method="POST">
            <input type="text" name="name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
            <textarea name="description"><?php echo htmlspecialchars($category['description']); ?></textarea>
            <button type="submit">Update Category</button>
        </form>
        <a href="manage_category.php">Back to Categories</a>
    </div>
</body>
</html>

