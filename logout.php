<?php
/* Logs out the user and deletes the session variables*/
session_start();
session_unset();
session_destroy(); 
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Error</title>
    <?php include 'css/css.html'; ?>
  </head>

  <body>
    <!-- Log out message -->
    <div class="form">
      <h1>Thank you for visiting</h1>
                
      <p><?= 'You have been logged out.'; ?></p>   
      <a href="index.php"><button class="button button-block">Home</button></a>

    </div>
  </body>
</html>