<?php
require 'dbconn.php';
session_start();

// Checks to make sure the email and hash variables are set.
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
{
    // Sets the variables to be queried.
    $email = $_GET['email'];
    $hash = $_GET['hash'];

    // Sets the SQL query results to the $result variable where 
    $result = $mysqli->query("SELECT * FROM user WHERE email='$email' AND hash='$hash'");

    // If there are no matching email and hash pairs.
    if($result->num_rows == 0)
    {
        $_SESSION['message'] = "You have entered an invalid URL.";
        header("location: error.php");
    }
}
else    // If email and hash variables were not set.
{
    $_SESSION['message'] = "Verification failed, try again.";
    header("location: error.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
    <?php include 'css/css.html'; ?>
</head>

<body>
    <div class = "form">
        <h1> Select your new password</h1>

        <form action = "reset_password.php" method = "post">

        <!-- Gets new password input -->
        <div class = "field-wrap">
            <label>
                New Password<span class = "req">*</span>
            </label>
            <input type="password" required name="newpassword" autocomplete="off"/>
        </div>

        <!-- Get the confirmation password -->
        <div class="field-wrap">
            <label>
                Confirm Password<span class="req">*</span>
            </label>
            <input type="password" required name="confirmpassword" autocomplete="off"/>
        </div>

        <!-- This gets the email of the user -->
        <input type="hidden" name="email" value="<?= $email ?>">    
        <input type="hidden" name="hash" value="<?= $hash ?>">    
                    
        <button class="button button-block">Reset</button>
                
        </form>

    </div>

    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js/index.js"></script>

</body>
</html>



