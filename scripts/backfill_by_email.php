<?php
// Backfill orphan submissions: match user by email, then award points if approved
include __DIR__ . '/../config.php';

echo "Starting email-based backfill...\n";

// Find submissions with no user_id but have submitter_email
$res = $conn->query("SELECT id, submitter_email, waste_type, weight, status, points_awarded FROM waste_submissions 
                      WHERE (user_id IS NULL OR user_id = '') 
                      AND submitter_email IS NOT NULL AND submitter_email <> ''");

if (!$res) {
    echo "Query error: " . $conn->error . "\n";
    exit(1);
}

$matched = 0;
$awarded = 0;

while ($row = $res->fetch_assoc()) {
    $email = $conn->real_escape_string($row['submitter_email']);
    $subId = intval($row['id']);
    $status = $row['status'];
    $points = intval($row['points_awarded']);

    // Find user by email
    $uRes = $conn->query("SELECT id FROM users WHERE email = '$email' LIMIT 1");
    if ($uRes && $uRow = $uRes->fetch_assoc()) {
        $userId = intval($uRow['id']);
        
        // Update submission with user_id
        $conn->query("UPDATE waste_submissions SET user_id = $userId WHERE id = $subId");
        $matched++;
        
        // If already approved and has points, award now
        if ($status === 'Approved' && $points > 0) {
            // Award points
            $conn->query("UPDATE users SET points = points + $points WHERE id = $userId");
            
            // Insert notification
            $title = $conn->real_escape_string('Waste Approved (Email Match)');
            $message = $conn->real_escape_string("Your waste submission for {$row['waste_type']} has been approved. You earned {$points} points.");
            $conn->query("INSERT INTO notifications (user_id, type, title, message, points_delta) VALUES ($userId, 'success', '$title', '$message', $points)");
            
            // Mark as granted
            $conn->query("UPDATE waste_submissions SET points_granted = 1 WHERE id = $subId");
            
            $awarded++;
            echo "✓ Matched & awarded: submission $subId → user $userId (+$points points)\n";
        } else {
            echo "✓ Matched: submission $subId → user $userId (pending/rejected)\n";
        }
    }
}

echo "Done. Matched: $matched | Awarded: $awarded\n";

?>
