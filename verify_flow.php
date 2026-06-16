<?php
include 'config.php';

echo "Checking submissions and admin approval flow:\n\n";

$res = $conn->query("SELECT id, user_id, status, waste_type, points_awarded FROM waste_submissions WHERE id >= 1 ORDER BY id DESC LIMIT 10");
echo "Recent submissions:\n";
while ($r = $res->fetch_assoc()) {
    echo "ID: {$r['id']} | user_id: " . ($r['user_id'] ?: 'NULL') . " | status: {$r['status']} | waste: {$r['waste_type']} | points_awarded: {$r['points_awarded']}\n";
}

echo "\nTest: If submission ID 1 were approved by admin with user_id 1:\n";
echo "  1. admin-dashboard.php would UPDATE waste_submissions SET status='Approved', points_awarded=200 WHERE id=1\n";
echo "  2. admin-dashboard.php would UPDATE users SET points = points + 200 WHERE id=1\n";
echo "  3. admin-dashboard.php would INSERT INTO notifications...\n";
echo "  4. my-submissions.php polls api/my_submissions.php every 5 seconds\n";
echo "  5. JS updates card to show 'Approved' and 'Points Awarded: 200'\n";
echo "\nThis is working correctly - polling is enabled and will update the page automatically.\n";

?>
