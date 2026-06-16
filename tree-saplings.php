<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = intval($_SESSION['user_id']);

$rewards = [
    1 => [
        'name' => 'Bonsai Tree',
        'desc' => 'Perfect indoor decorative plant.',
        'cost' => 100,
        'image' => 'pictures/bonsai.avif',
    ],
    2 => [
        'name' => 'Mango Tree',
        'desc' => 'Grow fresh mangoes at home.',
        'cost' => 10,
        'image' => 'pictures/mango.webp',
    ],
    3 => [
        'name' => 'Flower Tree',
        'desc' => 'Beautiful flowering garden tree.',
        'cost' => 80,
        'image' => 'pictures/flower.webp',
    ],
    4 => [
        'name' => 'Lemon Tree',
        'desc' => 'Fresh lemons directly from home.',
        'cost' => 60,
        'image' => 'pictures/lemon.webp',
    ],
    5 => [
        'name' => 'Cactus Plant',
        'desc' => 'Easy-care modern home plant.',
        'cost' => 90,
        'image' => 'pictures/cactus.jpg',
    ],
];

$alertMessage = '';
$alertType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reward_id'])) {
    $rewardId = intval($_POST['reward_id']);

    if (!isset($rewards[$rewardId])) {
        $alertMessage = 'Invalid reward selected.';
        $alertType = 'error';
    } else {
        $reward = $rewards[$rewardId];

        $result = mysqli_query($conn, "SELECT points FROM users WHERE id='$userId' LIMIT 1");
        $user = $result ? mysqli_fetch_assoc($result) : null;
        $currentPoints = $user ? intval($user['points']) : 0;

            if ($currentPoints >= $reward['cost']) {
            $newPoints = $currentPoints - $reward['cost'];
            mysqli_query($conn, "UPDATE users SET points='$newPoints' WHERE id='$userId'");
            $_SESSION['points'] = $newPoints;

            $alertMessage = "Success! You redeemed {$reward['name']} for {$reward['cost']} points.";
            $alertType = 'success';

            $notifTitle = mysqli_real_escape_string($conn, 'Reward Redeemed');
            $notifMessage = mysqli_real_escape_string($conn, "{$reward['name']} has been redeemed and {$reward['cost']} points were deducted.");
            $pointsDelta = -$reward['cost'];
            mysqli_query($conn, "INSERT INTO notifications (user_id, type, title, message, points_delta) VALUES ('$userId', 'success', '$notifTitle', '$notifMessage', '$pointsDelta')");
        } else {
            $alertMessage = "Not enough points for {$reward['name']}. You have {$currentPoints}, but need {$reward['cost']} points.";
            $alertType = 'warning';

            $notifTitle = mysqli_real_escape_string($conn, 'Not enough points');
            $notifMessage = mysqli_real_escape_string($conn, "You tried to redeem {$reward['name']} but only have {$currentPoints} points.");
            mysqli_query($conn, "INSERT INTO notifications (user_id, type, title, message) VALUES ('$userId', 'warning', '$notifTitle', '$notifMessage')");
        }
    }

    $_SESSION['flash_message'] = [
        'text' => $alertMessage,
        'type' => $alertType,
    ];

    header('Location: tree-saplings.php');
    exit;
}

if (isset($_SESSION['flash_message'])) {
    $alertMessage = htmlspecialchars($_SESSION['flash_message']['text']);
    $alertType = in_array($_SESSION['flash_message']['type'], ['success', 'warning', 'error', 'info']) ? $_SESSION['flash_message']['type'] : 'info';
    unset($_SESSION['flash_message']);
}

$points = isset($_SESSION['points']) ? intval($_SESSION['points']) : 0;
$notificationCount = 0;
$resultCount = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM notifications WHERE user_id='$userId'");
if ($resultCount) {
    $countRow = mysqli_fetch_assoc($resultCount);
    $notificationCount = intval($countRow['cnt']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tree Saplings - GoGreen</title>
<link rel="stylesheet" href="tree-saplings.css">
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">

    <div class="logo-section">
        <div class="logo-icon">🌱</div>

        <div>
            <div class="logo-text">GoGreen</div>
            <small>Smart Waste • Green Rewards</small>
        </div>
    </div>

    <div class="nav-links">
        <a href="dashBoard.php">Dashboard</a>
        <a href="SubmitWaste.php">Submit Waste</a>
        <a href="reward.php" class="active">Rewards</a>
        <a href="impact.php">Impact</a>
        <a href="profile.php">Profile</a>

        <div class="notification">
           <a href="notification.php">🔔</a>
            <span><?php echo $notificationCount > 0 ? $notificationCount : ''; ?></span>
        </div>

        <a href="login.php">Logout</a>
    </div>

</div>

<!-- PAGE -->
<div class="container">

    <div class="header">
        <div>
            <h1>🌱 Tree Saplings Store</h1>
            <p>Redeem eco-points for beautiful trees and make Bangladesh greener.</p>
        </div>

        <div class="points-box">
            Available Points
            <h2><?php echo $points; ?></h2>
        </div>
    </div>

    <?php if ($alertMessage): ?>
        <div class="alert <?php echo $alertType; ?>"><?php echo $alertMessage; ?></div>
    <?php endif; ?>

    <!-- PRODUCTS -->
    <div class="products">
        <?php foreach ($rewards as $id => $reward): ?>
            <div class="product-card">
                <img src="<?php echo htmlspecialchars($reward['image']); ?>" alt="<?php echo htmlspecialchars($reward['name']); ?>">
                <h3><?php echo htmlspecialchars($reward['name']); ?></h3>
                <p><?php echo htmlspecialchars($reward['desc']); ?></p>
                <div class="price"><?php echo $reward['cost']; ?> Points</div>
                <form method="post">
                    <input type="hidden" name="reward_id" value="<?php echo $id; ?>">
                    <button type="submit">Redeem Now</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

</div>

</body>
</html>
