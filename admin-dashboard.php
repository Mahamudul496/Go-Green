<?php
include 'config.php'; // Ensure this file has your database connection

// Fetch all submissions from newest to oldest
$query = "SELECT * FROM waste_submissions";
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
                        <th>Type</th>
                        <th>Weight</th>
                        <th>Address</th>
                        <th>Pickup Date</th>
                        <th>Slot</th>
                        <th>Status</th>
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
                                <td><strong><?php echo $row['waste_type']; ?></strong></td>
                                <td><?php echo $row['weight']; ?> kg</td>
                                <td><small><?php echo $row['address']; ?></small></td>
                                <td><?php echo date('d M, Y', strtotime($row['pickup_date'])); ?></td>
                                <td><?php echo $row['time_slot']; ?></td>
                                <td><span class="status-badge">Pending</span></td>
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