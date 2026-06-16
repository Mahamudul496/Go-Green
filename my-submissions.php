<?php
session_start();
include 'config.php';

ensureWasteSubmissionsSchema($conn);

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = intval($_SESSION['user_id']);

// Detect whether the current DB has the user_id column on waste_submissions
$hasUserIdColumn = false;
$columnCheck = $conn->query("SHOW COLUMNS FROM waste_submissions LIKE 'user_id'");
if ($columnCheck && $columnCheck->num_rows > 0) {
    $hasUserIdColumn = true;
}

if ($hasUserIdColumn) {
    $query = "SELECT * FROM waste_submissions WHERE user_id='$userId' ORDER BY submitted_at DESC";
} else {
    $query = "SELECT * FROM waste_submissions ORDER BY submitted_at DESC";
}
$result = $conn->query($query);

// Initialize the counter for numbering
$count = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Submissions - GoGreen</title>
    <link rel="stylesheet" href="SubmitWaste.css">
    <style>
        /* Specific styles for the submission list */
        .submission-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .submission-card:hover {
            transform: translateY(-3px);
        }

        /* Number Circle Style */
        .order-number {
            background: #2d6a4f;
            color: white;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            flex-shrink: 0;
            font-size: 1rem;
        }

        .waste-thumb {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            object-fit: cover;
        }

        .info-group {
            flex-grow: 1;
        }

        .status-tag {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .date-text {
            color: #777;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <header class="navbar">
        <div class="logo">🌱 GoGreen</div>
        <nav class="nav-right">
            <a href="dashBoard.php">Dashboard</a>
            <a href="SubmitWaste.php">Submit Waste</a>
            <a href="#" class="active">My Submissions</a>
            <a href="login.html">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h1>My Waste Submissions</h1>
        <p class="subtitle">Track the status of your recycling requests and earned points.</p>
        <p style="color:#16a34a; margin-top: 0; margin-bottom: 20px;">
            New users receive a 25-point bonus on first login.
        </p>

        <div class="list-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="submission-card">

                        <!-- 1. Numbering Badge -->
                        <div class="order-number">
                            <?php echo $count++; ?>
                        </div>

                        <!-- 2. Waste Image -->
                        <img src="<?php echo $row['image_path']; ?>" class="waste-thumb" alt="Waste Image">

                        <!-- 3. Details -->
                        <div class="info-group">
                            <h3 style="margin: 0; color: #2d6a4f;"><?php echo $row['waste_type']; ?></h3>
                            <p style="margin: 5px 0;" class="date-text">
                                Submitted on: <?php echo date('d M, Y', strtotime($row['submitted_at'])); ?>
                            </p>
                            <p style="margin: 0;"><strong>Weight:</strong> <?php echo $row['weight']; ?> kg</p>
                        </div>

                        <!-- 4. Status & Points -->
                        <?php $submissionStatus = $row['status'] ?? 'Pending'; ?>
                        <div style="text-align: right;">
                            <span class="status-tag"><?php echo htmlspecialchars($submissionStatus); ?></span>
                            <?php if ($submissionStatus === 'Approved'): ?>
                                <p style="margin-top: 10px; font-weight: bold; color: #1b4332;">
                                    Points Awarded: <?php echo intval($row['points_awarded'] ?? 0); ?>
                                </p>
                            <?php else: ?>
                                <p style="margin-top: 10px; font-weight: bold; color: #1b4332;">
                                    Est. Points: <?php echo ($row['weight'] * 10); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="card" style="text-align: center; padding: 40px;">
                    <p>You haven't submitted any waste yet.</p>
                    <a href="SubmitWaste.php" class="btn" style="text-decoration: none; display: inline-block; color: white;">Start Recycling</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>