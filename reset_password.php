<?php
require 'dbconn.php';
session_start();

// Checks if the form was sumbmited with "POST"
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

    // If the two passwords match
    if ( $_POST['newpassword'] == $_POST['confirmpassword'] ) 
    { 

        // Encrypts the newpassword to be stored into the user table
        $new_password = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);
        
        // Sets needed variables.
        $email = $_POST['email'];
        $hash = $_POST['hash'];
        
        // Query to change the users password
        $sql = "UPDATE user SET password='$new_password', hash='$hash' WHERE email='$email'";

        // Executes the $sql query.
        if ( $mysqli->query($sql) ) 
        {
        $_SESSION['message'] = "Password reset successful.";
        header("location: success.php");    
        }

    }
    else {  // If the passwords do not match.
        $_SESSION['message'] = "The two passwords you entered do not match, try again.";
        header("location: error.php");    
    }
}
?>