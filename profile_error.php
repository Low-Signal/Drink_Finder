<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
    <?php include 'css/css.html'; ?>
</head>
<body>
<div class ="form">
    <h1>Error</h1>
    <p>
    <?php

    if(isset($_SESSION['message']) AND !empty($_SESSION['message']))
        echo $_SESSION['message'];
    else
        header("location: profile.php");
    ?>
    </p>
    <a href="profile.php"><button class="button button-block">Back To Profile</button></a>
</div>
</body>
</html>