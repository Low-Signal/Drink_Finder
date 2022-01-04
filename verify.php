<?php
require 'dbconn.php';
session_start();

// Makes sure the email and hash variables are set.
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
{   
    // Sets the variables to be used.
    $email = $_GET['email'];
    $hash = $_GET['hash'];

    $result = $mysqli->query("SELECT * FROM user WHERE email='$email' AND hash='$hash' AND active='0'");

    // If the user has not been activated or the link is invalid.
    if($result->num_rows == 0)
    {
        $_SESSION['message'] = "This account has already been activated or the URL link is invalid.";

        header("location: error.php");
    }
    else {
        $_SESSION['message'] = "Your account has been successfully activated.";

        $mysqli->query("UPDATE user SET active='1' WHERE email='$email'") or die($mysqli->error);
        $_SESSION['active'] = 1;

        header("location: success.php");
    }
}
else{
    $_SESSION['message'] = "Invalid input for account verification.";
    header("location: error.php");
}
?>