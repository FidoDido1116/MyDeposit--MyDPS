<?php
include ('common.php');
session_start();

if(isset($_POST['submit'])){

   // Collecting form data
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   // Check if the email already exists
   $check_email = "SELECT * FROM users WHERE email = '$email'";
   $result = mysqli_query($conn, $check_email);

   if(mysqli_num_rows($result) > 0){
      $error[] = 'User already exists with this email!';
   } else {
      if($pass != $cpass){
         $error[] = 'Passwords do not match!';
      } else {
         // Insert new user into the database
         $insert = "INSERT INTO users(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
         if(mysqli_query($conn, $insert)){
            header('Location: login.php');
            exit(); // Ensure the script stops executing after redirect
         } else {
            $error[] = 'Error: ' . mysqli_error($conn);
         }
      }
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <link rel="stylesheet" href="css/logstyle.css" />
    <title>Register Page</title>
    <link rel="icon" type="image/png" sizes="16x16" href="LogoKastam.png" />
</head>

<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Register Now</h3>
      <?php
      if(isset($error)){
         foreach($error as $err){
            echo '<span class="error-msg">'.$err.'</span>';
         }
      }
      ?>
      <input type="text" name="name" required placeholder="Enter your name">
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="password" name="cpassword" required placeholder="Confirm your password">
      <select name="user_type" required>
         <option value="Staff">Staff</option>
         <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" value="Register" class="form-btn">
      <p>Already have an account? <a href="login.php">Login now</a></p>
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
