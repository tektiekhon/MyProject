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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Scholarship - Edu Africa</title>
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

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
    <script>
        function printPage() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Scholarship Details</h2>
        
        <p><strong>Name:</strong> <?php echo htmlspecialchars($scholarship['scholarship_name']); ?></p>
        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($scholarship['description'])); ?></p>
        <p><strong>Amount:</strong> $<?php echo $scholarship['amount']; ?></p>
        <p><strong>Deadline:</strong> <?php echo htmlspecialchars($scholarship['deadline']); ?></p>
        <p><strong>Criteria:</strong> <?php echo nl2br(htmlspecialchars($scholarship['criteria'])); ?></p>
        
        <button class="no-print" onclick="printPage()">Print Details</button>
        <br>
        <a class="no-print" href="manage_scholarship.php">Back to Manage Scholarships</a>
    </div>
</body>
</html>

