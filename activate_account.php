<?php
session_start();
require 'dbconn.php';
include 'css/css.html';

// Sets session variables to regular variables
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$email = $_SESSION['email'];
$active = $_SESSION['active'];


if ( !$active ){
    echo
    '
    <body>
        <div class ="form">
            Account is unverified, please confirm your email by clicking
            the link that was sent to your email address.
        </div>
    </body>';
}
else {
    header("location: profile.php");
}

?>

