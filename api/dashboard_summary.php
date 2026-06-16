<?php
session_start();
include __DIR__ . '/../config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

$userId = intval($_SESSION['user_id']);

// Points (prefer authoritative source from users table)
$points = 0;
$r = $conn->query("SELECT points FROM users WHERE id='$userId' LIMIT 1");
if ($r && $row = $r->fetch_assoc()) {
    $points = intval($row['points']);
}

// Total waste submitted (sum weight) for this user
$totalWaste = 0.0;
$res = $conn->query("SELECT SUM(weight) AS total_weight, COUNT(*) AS submissions_count, SUM(points_awarded) AS total_awarded FROM waste_submissions WHERE user_id='$userId'");
if ($res && $r2 = $res->fetch_assoc()) {
    $totalWaste = floatval($r2['total_weight'] ?? 0);
    $submissionsCount = intval($r2['submissions_count'] ?? 0);
    $totalAwarded = intval($r2['total_awarded'] ?? 0);
} else {
    $submissionsCount = 0;
    $totalAwarded = 0;
}

// CO2 reduction estimate: assume 0.5 kg CO2 avoided per kg of recycled waste
$co2_per_kg = 0.5; // adjust if you have a different factor
$co2Reduced = round($totalWaste * $co2_per_kg, 2);

// Trees planted estimate: 1 tree per 100 points (example)
$trees = intval(floor($points / 100));

echo json_encode([
    'points' => $points,
    'total_waste_kg' => $totalWaste,
    'submissions_count' => $submissionsCount,
    'co2_reduced_kg' => $co2Reduced,
    'trees_planted' => $trees,
    'total_awarded_points' => $totalAwarded,
]);

?>
