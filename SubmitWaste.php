<?php
include 'config.php';

/* 2. PROCESSING LOGIC */
if (isset($_POST['submit'])) {
    $waste_type = $_POST['waste_type'];
    $weight = $_POST['weight'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $pickup_date = $_POST['pickup_date'];
    $time_slot = $_POST['time_slot'];

    // Handle Image Upload
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Check if file was actually uploaded
    if (!empty($_FILES["waste_image"]["name"])) {
        $file_name = time() . "_" . basename($_FILES["waste_image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["waste_image"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO waste_submissions (waste_type, weight, description, address, pickup_date, time_slot, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sdsssss", $waste_type, $weight, $description, $address, $pickup_date, $time_slot, $target_file);

            if ($stmt->execute()) {
                echo "<script>alert('Waste submitted successfully!'); window.location.href='dashBoard.php';</script>";
                exit();
            } else {
                $error_msg = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error_msg = "Error uploading image.";
        }
    } else {
        $error_msg = "Please upload an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Waste - GoGreen</title>
    <link rel="stylesheet" href="SubmitWaste.css">
</head>

<body>

    <header class="navbar">
        <div class="logo">🌱 GoGreen</div>

        <nav class="nav-right">
            <a href="dashBoard.php">Dashboard</a>
            <a href="#" class="active">Submit Waste</a>
            <a href="#">Rewards</a>
            <a href="#">Impact</a>
            <a href="#">Profile</a>

            <div class="notification">
                🔔
                <span class="badge"></span>
                <div class="dropdown" id="notifBox">
                    <p><strong>Notifications</strong></p>
                    <ul>
                        <li>♻️ Waste pickup scheduled</li>
                        <li>🎉 You earned 50 points</li>
                        <li>🚚 Driver assigned</li>
                    </ul>
                </div>
            </div>
            <a href="login.php">Logout</a>
        </nav>
    </header>

    <div class="container">

        <h1>GoGreen | Submit Waste</h1>
        <p class="subtitle">Upload waste image, get AI-powered classification, and schedule pickup</p>

        <!-- ECO POINT BOX -->
        <div class="eco-box">
            <h3>📈 Eco-Points Calculator</h3>
            <p>Earn eco-points based on waste type and weight. Points are awarded after admin verification.</p>

            <div class="points-grid">
                <div>Plastic<br><span>15 pts/kg</span></div>
                <div>Paper<br><span>10 pts/kg</span></div>
                <div>Glass<br><span>8 pts/kg</span></div>
                <div>Metal<br><span>12 pts/kg</span></div>
                <div>E-waste<br><span>20 pts/kg</span></div>
                <div>Organic<br><span>5 pts/kg</span></div>
            </div>
        </div>

        <?php if (isset($error_msg)) echo "<p style='color:red; text-align:center;'>$error_msg</p>"; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card">
                <!-- UPLOAD -->
                <h3>1. Upload Waste Image</h3>
                <div class="upload-box">
                    <p>Upload an image (JPG/PNG)</p>
                    <input type="file" name="waste_image" accept="image/*" required>
                </div>

                <!-- WASTE DETAILS -->
                <h3>3. Waste Details</h3>
                <div class="grid">
                    <select name="waste_type" required>
                        <option value="">Select waste type</option>
                        <option value="Plastic">Plastic</option>
                        <option value="Paper">Paper</option>
                        <option value="Glass">Glass</option>
                        <option value="Metal">Metal</option>
                        <option value="E-waste">E-waste</option>
                        <option value="Organic">Organic</option>
                    </select>

                    <input type="number" name="weight" placeholder="Enter weight in kg" step="0.01" required>
                </div>

                <textarea name="description" placeholder="Add any additional details..."></textarea>

                <!-- PICKUP -->
                <h3>4. Pickup Details</h3>

                <textarea name="address" placeholder="Enter your complete address" required></textarea>

                <div class="grid">
                    <input type="date" name="pickup_date" required>
                    <select name="time_slot" required>
                        <option value="">Select time slot</option>
                        <option value="Morning">Morning</option>
                        <option value="Afternoon">Afternoon</option>
                        <option value="Evening">Evening</option>
                    </select>
                </div>

                <button type="submit" class="btn" name="submit">
                    Submit Waste & Schedule Pickup
                </button>
            </div>
        </form>
    </div>

    <?php $conn->close(); ?>
</body>

</html>