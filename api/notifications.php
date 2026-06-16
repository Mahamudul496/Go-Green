<?php
session_start();
include __DIR__ . '/../config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

$userId = intval($_SESSION['user_id']);

$res = $conn->query("SELECT id, type, title, message, points_delta, created_at FROM notifications WHERE user_id = $userId ORDER BY created_at DESC LIMIT 50");
$items = [];
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $items[] = $r;
    }
}

$countRes = $conn->query("SELECT COUNT(*) AS cnt FROM notifications WHERE user_id = $userId");
$count = 0;
if ($countRes && $cr = $countRes->fetch_assoc()) { $count = intval($cr['cnt']); }

echo json_encode(['count' => $count, 'notifications' => $items]);

?>
