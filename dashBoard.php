<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>GoGreen Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="left">
            <div class="logo-box">🌱</div>
            <div>
                <div class="logo-text">GoGreen</div>
                <small>Smart Waste • Green Rewards</small>
            </div>
        </div>

        <ul class="menu">
            <li class="active">Dashboard</li>

            <li>
                <a href="SubmitWaste.html" class="nav-link">Submit Waste</a>
            </li>
            <li>Rewards</li>
            <li>Impact</li>
            <li>Profile</li>

            <li class="icon-item">🔔 <span class="dot"></span></li>

            <li>
                <a href="login.html" class="nav-link">Logout</a>
            </li>
        </ul>
    </nav>

    <div class="container">

        <!-- ✅ Points left, title right -->
        <div class="title-row">


            <div class="dashboard-title-right">
                <h2>GoGreen | User Dashboard</h2>
                <p class="sub">Welcome back, Midul! Track your environmental impact and earn rewards</p>
            </div>
            <div class="points">
                🌟 <?php echo isset($_SESSION['points']) ? $_SESSION['points'] : 0; ?>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid">
            <div class="card">
                <div class="icon blue">♻️</div>
                <p>Total Waste Submitted</p>
                <h3>0 kg</h3>
            </div>

            <div class="card">
                <div class="icon green">🌿</div>
                <p>Eco-Points Earned</p>
                <h3><?php echo isset($_SESSION['points']) ? $_SESSION['points'] : 0; ?></h3>
            </div>

            <div class="card">
                <div class="icon darkgreen">🌲</div>
                <p>Trees Planted</p>
                <h3>0</h3>
            </div>

            <div class="card">
                <div class="icon purple">☁️</div>
                <p>CO₂ Reduced</p>
                <h3>0 kg</h3>
            </div>
        </div>

        <h3 class="section-title">Quick Actions</h3>

        <!-- Quick Actions -->
        <div class="grid">
            <a href="SubmitWaste.html" class="action-link">
                <div class="card">
                    <div class="icon blue">⬆️</div>
                    <h4>Submit Waste</h4>
                    <p>Upload waste for recycling</p>
                </div>
            </a>

            <div class="card">
                <div class="icon green">🚚</div>
                <h4>Manage Pickups</h4>
                <p>View and edit pickup requests</p>
            </div>

            <div class="card">
                <div class="icon purple">🎁</div>
                <h4>Rewards</h4>
                <p>Redeem your eco-points</p>
            </div>

            <div class="card">
                <div class="icon orange">📊</div>
                <h4>Environmental Impact</h4>
                <p>View your contribution</p>
            </div>
        </div>

        <!-- Bottom -->
        <div class="bottom">

            <div class="bottom-card">
                <div class="bottom-row">
                    <div>
                        <h4>My Submissions</h4>
                        <p>View waste history</p>
                    </div>
                    <span class="bicon green">♻️</span>
                </div>
            </div>

            <div class="bottom-card">
                <div class="bottom-row">
                    <div>
                        <h4>Notifications</h4>
                        <p>View updates</p>
                    </div>
                    <span class="badge">3</span>
                </div>
            </div>

            <div class="bottom-card">
                <div class="bottom-row">
                    <div>
                        <h4>Profile Settings</h4>
                        <p>Manage account</p>
                    </div>
                    <span class="bicon green">👤</span>
                </div>
            </div>

        </div>
    </div>

</body>

</html>