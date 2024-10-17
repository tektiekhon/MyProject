<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('login.php');
}

// Delete user
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM Registration WHERE user_id = ?");
    $stmt->execute([$id]);
}

// Fetch all users
$stmt = $pdo->query("SELECT * FROM Registration");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Edu Africa</title>
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
        <h2>Users</h2>
        
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>
                    <a href="view_user.php?id=<?php echo $user['user_id']; ?>">View</a>
                    <a href="edit_user.php?id=<?php echo $user['user_id']; ?>">Edit</a>
                    <a href="?delete=<?php echo $user['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <a href="dashboard.php" class="button">Back to Dashboard</a>
    </div>
</body>
</html>

