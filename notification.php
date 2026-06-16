<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = intval($_SESSION['user_id']);
$notifications = [];
$notificationCount = 0;
$result = mysqli_query($conn, "SELECT * FROM notifications WHERE user_id='$userId' ORDER BY created_at DESC");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $notifications[] = $row;
    }
    $notificationCount = count($notifications);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>GoGreen Notifications</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>

/* =========================
   BODY
========================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial,sans-serif;
    background:#f5f7fa;
    color:#111827;
}

/* =========================
   NAVBAR
========================= */

.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:15px 40px;

    background:white;

    border-bottom:1px solid #ddd;
}

.logo{
    font-weight:bold;
    font-size:20px;
}

/* NAV RIGHT */

.nav-right{
    display:flex;
    align-items:center;
    gap:20px;
}

/* NAV LINKS */

.nav-right a{
    position:relative;

    text-decoration:none;

    color:#555;

    font-weight:500;

    transition:all 0.3s ease;
}

/* HOVER */

.nav-right a:hover{
    color:#16a34a;
}

/* ACTIVE */

.nav-right a.active{
    color:#16a34a;
}

/* UNDERLINE */

.nav-right a::after{
    content:"";

    position:absolute;

    left:0;
    bottom:-5px;

    width:0%;
    height:2px;

    background:#16a34a;

    transition:0.3s ease;
}

.nav-right a:hover::after{
    width:100%;
}

.nav-right a.active::after{
    width:100%;
}

/* NOTIFICATION */

.notification{
    position:relative;
    cursor:pointer;
    font-size:20px;
}

/* RED DOT */

.badge{
    position:absolute;

    top:0;
    right:0;

    width:8px;
    height:8px;

    background:red;

    border-radius:50%;
}

/* DROPDOWN */

.dropdown{
    position:absolute;

    top:30px;
    right:0;

    width:220px;

    background:white;

    border-radius:10px;

    box-shadow:0 10px 20px rgba(0,0,0,0.15);

    padding:10px;

    display:none;

    z-index:100;
}

.dropdown ul{
    list-style:none;
    padding:0;
    margin:10px 0 0;
}

.dropdown li{
    padding:8px;
    border-radius:6px;
    font-size:14px;
    transition:0.3s;
}

.dropdown li:hover{
    background:#f3f4f6;
}
/* =========================
   MAIN
========================= */

.container{
    width:820px;
    margin:30px auto;
}

/* BACK */

.back{
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    color:#374151;
    margin-bottom:28px;
    font-size:15px;
}

.back:hover{
    color:#16a34a;
}

/* TOP */

.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.title{
    font-size:28px;
    font-weight:700;
    margin-bottom:8px;
}

.subtitle{
    color:#6b7280;
    font-size:16px;
}

.unread{
    background:#dcfce7;
    color:#15803d;
    padding:12px 20px;
    border-radius:12px;
    font-weight:600;
    display:flex;
    align-items:center;
    gap:10px;
}

/* =========================
   CARD
========================= */

.notifications{
    background:white;
    border-radius:20px;
    overflow:hidden;
    border:1px solid #e5e7eb;
}

.item{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    padding:24px;
    border-bottom:1px solid #e5e7eb;
    transition:0.3s;
}

.item:hover{
    background:#fafafa;
}

.item:last-child{
    border-bottom:none;
}

/* LEFT */

.item-left{
    display:flex;
    gap:16px;
}

/* ICON */

.icon{
    width:48px;
    height:48px;
    border-radius:12px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:22px;
}

.green{
    background:#dcfce7;
    color:#16a34a;
}

.blue{
    background:#dbeafe;
    color:#2563eb;
}

.purple{
    background:#f3e8ff;
    color:#9333ea;
}

.yellow{
    background:#fef9c3;
    color:#ca8a04;
}

/* CONTENT */

.content h3{
    font-size:17px;
    margin-bottom:8px;
}

.content p{
    color:#4b5563;
    margin-bottom:12px;
}

/* POINT */

.points{
    display:inline-block;
    background:#dcfce7;
    color:#15803d;
    padding:8px 14px;
    border-radius:20px;
    font-size:14px;
    font-weight:600;
}

/* TIME */

.time{
    color:#6b7280;
    font-size:14px;
}

/* BLUE DOT */

.dot-blue{
    color:#2563eb;
    font-size:12px;
}

/* =========================
   PREFERENCES SECTION
========================= */

.pref-box{
    background:white;
    margin-top:35px;
    border-radius:20px;
    padding:30px;
    border:1px solid #e5e7eb;
}

.pref-title{
    font-size:20px;
    font-weight:700;
    margin-bottom:30px;
}

.pref-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.pref-item:last-child{
    margin-bottom:0;
}

.pref-left h4{
    font-size:16px;
    margin-bottom:5px;
}

.pref-left p{
    color:#6b7280;
    font-size:14px;
}

/* TOGGLE */

.switch{
    position:relative;
    display:inline-block;
    width:46px;
    height:26px;
}

.switch input{
    opacity:0;
    width:0;
    height:0;
}

.slider{
    position:absolute;
    cursor:pointer;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background:#d1d5db;
    transition:.4s;
    border-radius:34px;
}

.slider:before{
    position:absolute;
    content:"";
    height:20px;
    width:20px;
    left:3px;
    bottom:3px;
    background:white;
    transition:.4s;
    border-radius:50%;
}

input:checked + .slider{
    background:#16a34a;
}

input:checked + .slider:before{
    transform:translateX(20px);
}

/* RESPONSIVE */

@media(max-width:900px){

    .container{
        width:95%;
    }

    .top{
        flex-direction:column;
        align-items:flex-start;
        gap:20px;
    }

    .navbar{
        flex-direction:column;
        gap:15px;
    }

    .nav-right{
        flex-wrap:wrap;
        justify-content:center;
    }

    .item{
        flex-direction:column;
        gap:15px;
    }

    .pref-item{
        gap:15px;
    }
}

</style>
</head>

<body>

<!-- NAVBAR -->

<!-- NAVBAR -->

<header class="navbar">

    <div class="logo">
        🌱 GoGreen
    </div>

    <nav class="nav-right">

        <a href="dashboard.php">
            Dashboard
        </a>

        <a href="SubmitWaste.php">
            Submit Waste
        </a>

        <a href="reward.php">
            Rewards
        </a>

        <a href="impactt.php">
            Impact
        </a>

        <a href="profile.php">
            Profile
        </a>

        <!-- Notification -->

        <div class="notification" id="notifBtn">

            🔔

            <span class="badge"><?php echo $notificationCount; ?></span>

            <div class="dropdown" id="notifBox">

                <p><strong>Notifications</strong></p>

                <ul>
                    <?php if (count($notifications) > 0): ?>
                        <?php foreach (array_slice($notifications, 0, 3) as $notification): ?>
                            <li><?php echo htmlspecialchars($notification['title'] . ' — ' . $notification['message']); ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No notifications yet</li>
                    <?php endif; ?>
                </ul>

            </div>

        </div>

        <a href="login.php">
            Logout
        </a>

    </nav>

</header>

<!-- MAIN -->

<div class="container">

    <a href="dashboard.php" class="back">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Dashboard
    </a>

    <div class="top">

        <div>

            <h1 class="title">
                Notifications
            </h1>

            <p class="subtitle">
                Stay updated with your GoGreen activity
            </p>

        </div>

        <div class="unread">
            <i class="fa-regular fa-bell"></i>
            <?php echo $notificationCount; ?> Unread
        </div>

</div>

<!-- NOTIFICATION LIST -->

<div class="notifications">
<?php
if (count($notifications) > 0):
    foreach ($notifications as $notification):
        $type = $notification['type'] ?? 'info';
        $iconClass = 'fa-info-circle';
        $colorClass = 'blue';

        if ($type === 'success') {
            $iconClass = 'fa-circle-check';
            $colorClass = 'green';
        } elseif ($type === 'warning') {
            $iconClass = 'fa-circle-exclamation';
            $colorClass = 'yellow';
        }
?>
        <div class="item">
            <div class="item-left">
                <div class="icon <?php echo $colorClass; ?>">
                    <i class="fa-solid <?php echo $iconClass; ?>"></i>
                </div>

                <div class="content">
                    <h3>
                        <?php echo htmlspecialchars($notification['title']); ?>
                        <?php if (!empty($notification['dot'])): ?>
                            <span class="dot-blue">●</span>
                        <?php endif; ?>
                    </h3>

                    <p>
                        <?php echo htmlspecialchars($notification['text'] ?? $notification['message'] ?? ''); ?>
                    </p>

                    <?php
                        $pointsLabel = '';
                        if (!empty($notification['points'])) {
                            $pointsLabel = $notification['points'];
                        } elseif (isset($notification['points_delta']) && $notification['points_delta'] !== null) {
                            $pointsLabel = ($notification['points_delta'] > 0 ? '+' : '') . $notification['points_delta'] . ' points';
                        }
                    ?>

                    <?php if ($pointsLabel !== ''): ?>
                        <span class="points">
                            <?php echo htmlspecialchars($pointsLabel); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="time">
                <?php echo htmlspecialchars($notification['created_at'] ?? 'Just now'); ?>
            </div>
        </div>
<?php
    endforeach;
else:
?>
        <div class="item">
            <div class="item-left">
                <div class="icon blue">
                    <i class="fa-solid fa-bell"></i>
                </div>

                <div class="content">
                    <h3>
                        No notifications yet
                    </h3>

                    <p>
                        Any reward updates will appear here.
                    </p>
                </div>
            </div>

            <div class="time">
                --
            </div>
        </div>
<?php endif; ?>

    </div>

    <!-- NOTIFICATION PREFERENCES -->

    <div class="pref-box">

        <h2 class="pref-title">
            Notification Preferences
        </h2>

        <div class="pref-item">

            <div class="pref-left">
                <h4>Waste Approvals</h4>
                <p>Get notified when your submissions are approved</p>
            </div>

            <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
            </label>

        </div>

        <div class="pref-item">

            <div class="pref-left">
                <h4>Pickup Updates</h4>
                <p>Receive updates about your pickup requests</p>
            </div>

            <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
            </label>

        </div>

        <div class="pref-item">

            <div class="pref-left">
                <h4>Reward Redemptions</h4>
                <p>Stay informed about your reward redemptions</p>
            </div>

            <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
            </label>

        </div>

        <div class="pref-item">

            <div class="pref-left">
                <h4>Promotional Offers</h4>
                <p>Receive special offers and updates</p>
            </div>

            <label class="switch">
                <input type="checkbox">
                <span class="slider"></span>
            </label>

        </div>

    </div>

</div>

<script>

/* DROPDOWN */

const notifBtn = document.getElementById("notifBtn");
const notifBox = document.getElementById("notifBox");

notifBtn.addEventListener("click", function(e){

    e.stopPropagation();

    if(notifBox.style.display === "block"){
        notifBox.style.display = "none";
    }

    else{
        notifBox.style.display = "block";
    }

});

document.addEventListener("click", function(){

    notifBox.style.display = "none";

});

</script>

</body>
</html>