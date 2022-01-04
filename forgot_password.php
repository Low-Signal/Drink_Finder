<?php
require 'dbconn.php';
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $email = $_POST['email'];
    $result = $mysqli->query("SELECT * FROM user WHERE email='$email'");

    // If there are no email matching the user input.
    if($result->num_rows == 0)
    {
        $_SESSION['message'] = "That email does not exist.";
        header("location: error.php");
    }
    else    // If the email is correct send password reset verification email.
    {
        $user = $result->fetch_assoc();     // Converts results into an array object.

        $email = $user['email'];
        $hash = $user['hash'];
        $first_name = $user['first_name'];

        $_SESSION['message'] = "<p>Please check your email for a confirmation link to complete your password reset.</p>";

        $to = $email;
        $subject = 'Password Reset Link For Drink Finder';
        $message_body = 'Hello '.$first_name.',
        To reset your password please click the following link:

        http://localhost/drink_finder/reset.php?email='.$email.'&hash='.$hash;

        mail($to, $subject, $message_body);

        header("location: success.php");

    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password</title>
  <?php include 'css/css.html'; ?>
</head>

<body>
    
  <div class="form">

    <h1>Reset Your Password</h1>

    <form action="forgot_password.php" method="post">
     <div class="field-wrap">
      <label>
        Email Address<span class="req">*</span>
      </label>
      <input type="email"required autocomplete="off" name="email"/>
    </div>
    <button class="button button-block">Reset</button>
    </form>
  </div>
          
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>

</html>