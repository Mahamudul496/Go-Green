<?php
$conn = mysqli_connect("localhost", "root", "", "gogreen");

function ensureWasteSubmissionsSchema($conn) {
    $columns = [
        'user_id' => "int(11) DEFAULT NULL",
        'status' => "varchar(20) NOT NULL DEFAULT 'Pending'",
        'points_awarded' => "int(11) DEFAULT 0",
    ];

    foreach ($columns as $column => $definition) {
        $check = $conn->query("SHOW COLUMNS FROM waste_submissions LIKE '$column'");
        if ($check && $check->num_rows === 0) {
            $conn->query("ALTER TABLE waste_submissions ADD COLUMN $column $definition");
        }
    }
}
?>