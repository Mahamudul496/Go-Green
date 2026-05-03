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
include 'config.php' ; 
if (isset($_POST['submit'])) 
{ $email=$_POST['email']; 
  $password=$_POST['password'];
  $sql="SELECT * FROM users WHERE email='$email' AND password='$password'" ;
   $result=mysqli_query($conn, $sql); 
if(mysqli_num_rows($result)==1) 
{ header("Location: dashBoard.php"); 
exit(); 
} else 
{
    echo "Invalid email or password." ; } 
} 
?>

<?php
$conn = mysqli_connect("localhost", "root", "", "gogreen");
?>