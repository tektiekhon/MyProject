<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('login.php');
}

// Fetch application details
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT a.*, r.first_name, r.last_name, s.scholarship_name 
                            FROM Application a 
                            JOIN Registration r ON a.user_id = r.user_id 
                            JOIN Scholarship s ON a.scholarship_id = s.scholarship_id 
                            WHERE a.application_id = ?");
    $stmt->execute([$id]);
    $application = $stmt->fetch();

    if (!$application) {
        echo "Application not found.";
        exit;
    }
} else {
    echo "No application ID specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Application - Edu Africa</title>
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
            font-size: 1.2rem;
            margin-bottom: 1rem;
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
            margin-right: 1rem;
        }

        button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-size: 1rem;
        }

        a:hover {
            color: #45a049;
            text-decoration: underline;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Application Details</h2>
        <p><strong>Applicant:</strong> <?php echo htmlspecialchars($application['first_name'] . ' ' . $application['last_name']); ?></p>
        <p><strong>Scholarship:</strong> <?php echo htmlspecialchars($application['scholarship_name']); ?></p>
        <p><strong>Submission Date:</strong> <?php echo htmlspecialchars($application['submission_date']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($application['application_status']); ?></p>

        <button class="no-print" onclick="window.print();">Print</button>
        <a class="no-print" href="view_applications.php">Back to Applications</a>
    </div>
</body>
</html>

