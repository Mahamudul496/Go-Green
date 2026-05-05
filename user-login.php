<!DOCTYPE html>
<html>

<head>
    <title>User Login</title>
    <link rel="stylesheet" href="form2.css">
</head>

<body>

    <form action="" method="post">
        <div class="form-box">
            <h2>User Login</h2>
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <button type="submit" name="submit">Login</button>
        </div>
    </form>

</body>

</html>



<?php
include 'config.php';
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // ✅ Give 25 points ONLY first time
        if ($user['bonus_given'] == 0) {
            $newPoints = $user['points'] + 25;

            $sqlPoints = "UPDATE users SET points='$newPoints', bonus_given=1 WHERE id=" . $user['id'];
            mysqli_query($conn, $sqlPoints);

            $user['points'] = $newPoints;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['points'] = $user['points'];

        header("Location: dashBoard.php");
        exit();

    } else {
        echo "Invalid email or password.";
    }
}

?>