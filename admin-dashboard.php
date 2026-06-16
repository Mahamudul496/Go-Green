<?php
session_start();
include 'config.php'; // Ensure this file has your database connection

function getPointsForWasteType($type, $weight) {
    $rates = [
        'Plastic' => 15,
        'Paper' => 10,
        'Glass' => 8,
        'Metal' => 12,
        'E-waste' => 20,
        'Organic' => 5,
    ];
    return intval(($rates[$type] ?? 10) * floatval($weight));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['submission_id'])) {
    $submissionId = intval($_POST['submission_id']);
    $action = $_POST['action'];

    $submissionResult = $conn->query("SELECT * FROM waste_submissions WHERE id='$submissionId' LIMIT 1");
    $submission = $submissionResult ? $submissionResult->fetch_assoc() : null;

    if ($submission) {
        $userId = intval($submission['user_id']);
        if ($action === 'approve') {
            $points = getPointsForWasteType($submission['waste_type'], $submission['weight']);
            $conn->query("UPDATE waste_submissions SET status='Approved', points_awarded='$points' WHERE id='$submissionId'");
            $conn->query("UPDATE users SET points = points + $points WHERE id='$userId'");
            $title = mysqli_real_escape_string($conn, 'Waste Approved');
            $message = mysqli_real_escape_string($conn, "Your waste submission for {$submission['waste_type']} has been approved. You earned {$points} points.");
            $conn->query("INSERT INTO notifications (user_id, type, title, message, points_delta) VALUES ('$userId', 'success', '$title', '$message', '$points')");
        } elseif ($action === 'reject') {
            $conn->query("UPDATE waste_submissions SET status='Rejected', points_awarded=0 WHERE id='$submissionId'");
            $title = mysqli_real_escape_string($conn, 'Waste Rejected');
            $message = mysqli_real_escape_string($conn, "Your waste submission for {$submission['waste_type']} has been rejected by admin.");
            $conn->query("INSERT INTO notifications (user_id, type, title, message) VALUES ('$userId', 'warning', '$title', '$message')");
        }
    }

    header('Location: admin-dashboard.php');
    exit;
}

// Fetch submissions with user information
$query = "SELECT ws.*, u.name AS user_name, u.email AS user_email FROM waste_submissions ws LEFT JOIN users u ON ws.user_id = u.id ORDER BY ws.submitted_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Waste Requests | GoGreen</title>
    <!-- Reusing your existing CSS for consistent UI/UX -->
    <link rel="stylesheet" href="SubmitWaste.css">

    <style>
        /* Add any additional styles specific to the admin dashboard here */
        /* Table specific styles to ensure it looks good within your UI */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .admin-table th,
        .admin-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .admin-table th {
            background-color: #2d6a4f;
            /* Green theme matching GoGreen */
            color: white;
            font-weight: 600;
        }

        .admin-table tr:hover {
            background-color: #f9f9f9;
        }

        .waste-img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            cursor: pointer;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            background: #e9f5ee;
            color: #2d6a4f;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <header class="navbar">
        <div class="logo">🌱 GoGreen Admin</div>
        <nav class="nav-right">
            <a href="admin-dashboard.php">Dashboard</a>
            <a href="#" class="active">Waste Requests</a>
            <a href="#">Manage Users</a>
            <a href="login.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h1>Admin | Waste Collection Requests</h1>
        <p class="subtitle">Review and verify user-submitted waste for point allocation.</p>

        <div class="card" style="padding: 0; overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Weight</th>
                        <th>Address</th>
                        <th>Pickup Date</th>
                        <th>Slot</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($row['image_path'])): ?>
                                        <img src="<?php echo $row['image_path']; ?>" class="waste-img" onclick="window.open(this.src)">
                                    <?php else: ?>
                                        <span>No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?php echo htmlspecialchars($row['user_name'] ?: $row['user_email'] ?: 'Unknown'); ?></strong></td>
                                <td><?php echo $row['waste_type']; ?></td>
                                <td><?php echo $row['weight']; ?> kg</td>
                                <td><small><?php echo $row['address']; ?></small></td>
                                <td><?php echo date('d M, Y', strtotime($row['pickup_date'])); ?></td>
                                <td><?php echo $row['time_slot']; ?></td>
                                <td>
                                    <?php if ($row['status'] === 'Approved'): ?>
                                        <span class="status-badge" style="background:#d1fae5; color:#166534;">Approved</span>
                                    <?php elseif ($row['status'] === 'Rejected'): ?>
                                        <span class="status-badge" style="background:#fee2e2; color:#991b1b;">Rejected</span>
                                    <?php else: ?>
                                        <span class="status-badge"><?php echo htmlspecialchars($row['status']); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] === 'Pending'): ?>
                                        <form method="post" style="display:inline-block; margin-right:5px;">
                                            <input type="hidden" name="submission_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" style="padding:8px 12px; background:#16a34a; color:white; border:none; border-radius:8px; cursor:pointer;">Approve</button>
                                        </form>
                                        <form method="post" style="display:inline-block;">
                                            <input type="hidden" name="submission_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" style="padding:8px 12px; background:#f97316; color:white; border:none; border-radius:8px; cursor:pointer;">Reject</button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color:#6b7280;">No actions</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align:center; padding: 30px;">No requests found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>