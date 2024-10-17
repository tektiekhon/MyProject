<?php
require_once 'db.php';
require_once 'utils.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('login.php');
}

// Update application status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $application_id = intval($_POST['application_id']);
    $status = sanitizeInput($_POST['status']);
    
    $stmt = $pdo->prepare("UPDATE Application SET application_status = ? WHERE application_id = ?");
    $stmt->execute([$status, $application_id]);
}

// Fetch all applications
$stmt = $pdo->query("SELECT a.*, r.first_name, r.last_name, s.scholarship_name 
                     FROM Application a 
                     JOIN Registration r ON a.user_id = r.user_id 
                     JOIN Scholarship s ON a.scholarship_id = s.scholarship_id");
$applications = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applications - Edu Africa</title>
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
            max-width: 900px;
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
            margin-bottom: 2rem;
        }

        th, td {
            border: 1px solid #4CAF50;
            padding: 1rem;
            text-align: left;
        }

        th {
            background-color: #2c2c2c;
        }

        tr:nth-child(even) {
            background-color: #2c2c2c;
        }

        select, button {
            padding: 0.5rem;
            border-radius: 5px;
            border: none;
            margin-right: 1rem;
        }

        select {
            background-color: #2e2e2e;
            color: #ffffff;
        }

        button {
            background-color: #4CAF50;
            color: #ffffff;
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
</head>
<body>
    <div class="container">
        <h2>View Applications</h2>
        
        <table>
            <tr>
                <th>Applicant</th>
                <th>Scholarship</th>
                <th>Submission Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($applications as $application): ?>
            <tr>
                <td><?php echo htmlspecialchars($application['first_name'] . ' ' . $application['last_name']); ?></td>
                <td><?php echo htmlspecialchars($application['scholarship_name']); ?></td>
                <td><?php echo $application['submission_date']; ?></td>
                <td><?php echo $application['application_status']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="application_id" value="<?php echo $application['application_id']; ?>">
                        <select name="status">
                            <option value="pending" <?php echo $application['application_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="approved" <?php echo $application['application_status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                            <option value="rejected" <?php echo $application['application_status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                        <button type="submit" name="update_status">Update</button>
                    </form>
                    <a href="view_application.php?id=<?php echo $application['application_id']; ?>">View</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>

