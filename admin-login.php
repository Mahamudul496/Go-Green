<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="form2.css">
</head>

<body>

    <form action="admin-login.php" method="POST">
        <div class="form-box">
            <h2>Admin Login</h2>
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <button type="submit" name="submit">Login</button>
        </div>
    </form>

</body>

</html>

<?php
include 'config.php';

if(isset($_POST['submit']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        header("Location: admin-dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid email or password');</script>";
    }
}

?>