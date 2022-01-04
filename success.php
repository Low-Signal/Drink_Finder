<?php
// This file sends a success message based on the $_SESSION message.
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Success</title>
    <?php include 'css/css.html'; ?>
</head>
<body>
<div class ="form">
    <h1>Success</h1>
    <p>
    <?php

    if(isset($_SESSION['message']) AND !empty($_SESSION['message']))
        echo $_SESSION['message'];
    else
        header("location: index.php");
    ?>
    </p>
    <a href="index.php"><button class="button button-block">Home</button></a>
</div>
</body>
</html>