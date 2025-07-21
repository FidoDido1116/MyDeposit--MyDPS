<?php
include ('common.php');
session_start();

if(isset($_POST['submit'])){

   // Collecting form data
   $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
   $pass = isset($_POST['password']) ? md5($_POST['password']) : '';

   // Query to check if user exists
   $select = "SELECT * FROM users WHERE email = '$email' AND password = '$pass'";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_array($result);

      if($row['user_type'] == 'admin'){
         $_SESSION['admin_name'] = $row['name'];
         header('location:admin.php');
      } elseif($row['user_type'] == 'staff') {
         $_SESSION['user_name'] = $row['name'];
         header('location:main.php');
      }
   } else {
      $error[] = 'Incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="css/logstyle.css" />
    <title>Login Page</title>
    <link rel="icon" type="image/png" sizes="16x16" href="LogoKastam.png" />
</head>

<body>
   
<div class="form-container">
   <form action="" method="post">
      <h3>Login Now</h3>
      <?php
      if(isset($error)){
         foreach($error as $err){
            echo '<span class="error-msg">'.$err.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="Login" class="form-btn">
      <p>Don't have an account? <a href="register.php">Register</a></p>
   </form>
</div>

<script>
    // JavaScript to change background image automatically
    const images = [
        'images/pexels-ketut-subiyanto-4963437.jpg',
        'images/pexels-pixabay-164686.jpg',
        'images/pexels-pixabay-265087.jpg'
    ];

    let currentIndex = 0;

    function changeBackgroundImage() {
        document.body.style.backgroundImage = `url(${images[currentIndex]})`;
        currentIndex = (currentIndex + 1) % images.length;
    }

    setInterval(changeBackgroundImage, 10000); // Change every 10 seconds

    window.onload = changeBackgroundImage;
</script>

</body>
</html>
