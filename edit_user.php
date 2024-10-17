<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('login.php');
}

// Fetch user details
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM Registration WHERE user_id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "User not found.";
        exit;
    }
}

// Update user details
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $firstName = sanitizeInput($_POST['first_name']);
    $lastName = sanitizeInput($_POST['last_name']);
    $email = sanitizeInput($_POST['email']);
    $role = sanitizeInput($_POST['role']);

    $stmt = $pdo->prepare("UPDATE Registration SET first_name = ?, last_name = ?, email = ?, role = ? WHERE user_id = ?");
    $stmt->execute([$firstName, $lastName, $email, $role, $id]);

    redirect('manage_users.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Edu Africa</title>
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
            max-width: 500px;
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
        input[type="email"],
        select {
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
        <h2>Edit User</h2>
        <form method="POST">
            <input type="text" name="first_name" placeholder="First Name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            <input type="text" name="last_name" placeholder="Last Name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <select name="role" required>
                <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
            </select>
            <button type="submit" name="update">Update User</button>
        </form>
        <a href="manage_users.php">Back to Manage Users</a>
    </div>
</body>
</html>

