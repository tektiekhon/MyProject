<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM Registration WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Update user profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $email = sanitizeInput($_POST['email']);

    $stmt = $pdo->prepare("UPDATE Registration SET first_name = ?, last_name = ?, email = ? WHERE user_id = ?");
    $stmt->execute([$first_name, $last_name, $email, $user_id]);

    // Refresh user data
    $stmt = $pdo->prepare("SELECT * FROM Registration WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    $success = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Edu Africa</title>
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

        input[type="text"],
        input[type="email"] {
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
        }

        button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
        }

        .success {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 1rem;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 1rem;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Profile</h2>
        
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>

        <form method="POST">
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <button type="submit">Update Profile</button>
        </form>
        
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
