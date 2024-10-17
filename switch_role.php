<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_role = $_POST['role'] == 'administrator' ? 'administrator' : 'student';
    
    $stmt = $pdo->prepare("UPDATE Registration SET role = ? WHERE user_id = ?");
    $stmt->execute([$new_role, $user_id]);
    
    $_SESSION['role'] = $new_role;
    
    redirect('dashboard.php');
}

$stmt = $pdo->prepare("SELECT role FROM Registration WHERE user_id = ?");
$stmt->execute([$user_id]);
$current_role = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Switch Role - Edu Africa</title>
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

        p {
            margin-bottom: 1rem;
            text-align: center;
        }

        select {
            width: 100%;
            padding: 0.5rem;
            margin: 1rem 0;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            background-color: #2a2a2a;
            color: #ffffff;
        }

        button {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 1rem;
            text-align: center;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Switch Role</h2>
        <p>Current role: <?php echo ucfirst($current_role); ?></p>
        <form method="POST">
            <select name="role">
                <option value="student" <?php echo $current_role == 'student' ? 'selected' : ''; ?>>Student</option>
                <option value="administrator" <?php echo $current_role == 'administrator' ? 'selected' : ''; ?>>Administrator</option>
            </select>
            <button type="submit">Switch Role</button>
        </form>
        <a href="dashboard.php" class="button">Back to Dashboard</a>
    </div>
</body>
</html>
