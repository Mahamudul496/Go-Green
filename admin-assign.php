<?php
session_start();
include 'config.php';

// Handle assignment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submission_id'], $_POST['user_id'])) {
    $sid = intval($_POST['submission_id']);
    $uid = intval($_POST['user_id']);
    $conn->query("UPDATE waste_submissions SET user_id = $uid WHERE id = $sid");

    // If already approved and points_awarded > 0, award immediately
    $sRes = $conn->query("SELECT status, points_awarded, waste_type FROM waste_submissions WHERE id = $sid LIMIT 1");
    if ($sRes && $s = $sRes->fetch_assoc()) {
        if ($s['status'] === 'Approved' && intval($s['points_awarded']) > 0) {
            $points = intval($s['points_awarded']);
            $conn->query("UPDATE users SET points = points + $points WHERE id = $uid");
            $title = $conn->real_escape_string('Waste Approved');
            $message = $conn->real_escape_string("Your waste submission for {$s['waste_type']} has been approved. You earned {$points} points.");
            $conn->query("INSERT INTO notifications (user_id, type, title, message, points_delta) VALUES ($uid, 'success', '$title', '$message', $points)");
            $conn->query("UPDATE waste_submissions SET points_granted = 1 WHERE id = $sid");
        }
    }

    header('Location: admin-assign.php'); exit;
}

// Show orphan submissions
$res = $conn->query("SELECT id, waste_type, weight, address, submitter_email, submitted_at FROM waste_submissions WHERE user_id IS NULL OR user_id = '' ORDER BY submitted_at DESC");
$users = $conn->query("SELECT id, name, email FROM users ORDER BY name ASC");

?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Assign Submissions to Users</title></head>
<body>
<h2>Orphan Submissions</h2>
<?php if ($res && $res->num_rows): ?>
  <table border="1" cellpadding="6">
    <tr><th>ID</th><th>Type</th><th>Weight</th><th>Address</th><th>Submitter Email</th><th>Assign</th></tr>
    <?php while ($r = $res->fetch_assoc()): ?>
    <tr>
      <td><?php echo $r['id']; ?></td>
      <td><?php echo htmlspecialchars($r['waste_type']); ?></td>
      <td><?php echo htmlspecialchars($r['weight']); ?> kg</td>
      <td><?php echo htmlspecialchars($r['address']); ?></td>
      <td><?php echo htmlspecialchars($r['submitter_email']); ?></td>
      <td>
        <form method="post">
          <input type="hidden" name="submission_id" value="<?php echo $r['id']; ?>">
          <select name="user_id">
            <option value="">-- Select user --</option>
            <?php if ($users) { $users->data_seek(0); while ($u = $users->fetch_assoc()): ?>
              <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['name'] . ' <' . $u['email'] . '>'); ?></option>
            <?php endwhile; } ?>
          </select>
          <button type="submit">Assign</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
<?php else: ?>
  <p>No orphan submissions found.</p>
<?php endif; ?>
</body>
</html>
