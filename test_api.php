<?php
session_start();
$_SESSION['user_id'] = 5; // Test as user 5

include __DIR__ . '/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

$userId = intval($_SESSION['user_id']);

$data = [];

// current points
$points = 0;
$r = $conn->query("SELECT points FROM users WHERE id='$userId' LIMIT 1");
if ($r && $row = $r->fetch_assoc()) {
    $points = intval($row['points']);
}

echo "User $userId points: $points\n\n";

// submissions
$subs = [];
$res = $conn->query("SELECT id, waste_type, weight, image_path, address, pickup_date, time_slot, status, points_awarded, submitted_at FROM waste_submissions WHERE user_id='$userId' ORDER BY submitted_at DESC");
if ($res) {
    while ($s = $res->fetch_assoc()) {
        $subs[] = $s;
    }
}

echo "Submissions for user $userId:\n";
print_r($subs);

?>
