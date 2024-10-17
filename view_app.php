<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn() || isAdmin()) {
    redirect('login.php');
}

if (!isset($_GET['id'])) {
    redirect('apply_scholarship.php'); // Redirect if no ID is provided
}

$application_id = intval($_GET['id']);

// Fetch the application details
$stmt = $pdo->prepare("SELECT a.*, r.first_name, r.last_name, s.scholarship_name 
                        FROM Application a 
                        JOIN Registration r ON a.user_id = r.user_id 
                        JOIN Scholarship s ON a.scholarship_id = s.scholarship_id 
                        WHERE a.application_id = ?");
$stmt->execute([$application_id]);
$application = $stmt->fetch();

if (!$application) {
    redirect('apply_scholarship.php'); // Redirect if application not found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details - Edu Africa</title>
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
            font-size: 1.2rem;
        }

        strong {
            color: #4CAF50;
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

        /* Hide the print button and back button when printing */
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
        <p><strong>Course:</strong> <?php echo htmlspecialchars($application['course']); ?></p>
        <p><strong>Submission Date:</strong> <?php echo htmlspecialchars($application['submission_date']); ?></p>
        <p><strong>Supporting Documents:</strong> <?php echo htmlspecialchars($application['supporting_documents']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($application['application_status']); ?></p>

        <button onclick="window.print()" class="no-print">Print</button>
        <a href="apply_scholarship.php" class="no-print">Back to Your Applications</a>
    </div>
</body>
</html>


