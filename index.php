<?php
// Main login page.
require 'dbconn.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <?php include 'css/css.html'; ?>
</head>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // Includes file based on user selection.
    if(isset($_POST['login']))
    {   require 'login.php';}
    elseif (isset($_POST['signup']))
    {   require 'sign_up.php';}
}
?>
<body>
  <div class="form">

      <!-- Creates two tabs -->
    <ul class="tab-group">
        <li class="tab"><a href="#signup">Sign Up</a></li>
        <li class="tab active"><a href="#login">Log In</a></li>
    </ul>
      
    <div class="tab-content">
        
        <!-- Login tab -->
        <div id="login">   
            <h1>Welcome to Drink Finder</h1>
            
            <form action="index.php" method="post" autocomplete="off">

                <!-- For email entry -->
                <div class="field-wrap">
                    <label>
                        Email Address<span class="req">*</span>
                    </label>
                    <input type="email" required autocomplete="off" name="email"/>
                </div>
                
                <!-- For password entry -->
                <div class="field-wrap">
                    <label>
                        Password<span class="req">*</span>
                    </label>
                    <input type="password" required autocomplete="off" name="password"/>
                </div>

                <!-- Link to forgot password page -->
                <p class="forgot"><a href="forgot_password.php">Forgot Password?</a></p>
                
                <!-- Button to login -->
                <button class="button button-block" name="login">Log In</button>
            
            </form>

        </div>

        <!-- Signup tab -->
        <div id="signup">   
            <h1>Sign Up</h1>
          
            <form action="index.php" method="post" autocomplete="off">
          
            <div class="top-row">
                <div class="field-wrap">
                    <label>
                        First Name<span class="req"></span>
                    </label>
                    <input type="text" required autocomplete="off" name='firstname' />
                </div>
        
                <div class="field-wrap">
                    <label>
                        Last Name<span class="req"></span>
                    </label>
                    <input type="text"required autocomplete="off" name='lastname' />
                </div>
            </div>

            <div class="field-wrap">
                <label>
                    Age<span class="req"></span>
                </label>
                <input type="number"required autocomplete="off" name='age' />
            </div>
        
            <div class="dropbox">
                <select name="gender">
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="field-wrap">
                <label>
                    Email Address<span class="req"></span>
                </label>
                <input type="email"required autocomplete="off" name='email' />
            </div>
          
            <div class="field-wrap">
                <label>
                    Set A Password<span class="req"></span>
                </label>
                <input type="password"required autocomplete="off" name='password'/>
            </div>
          
            <button type="submit" class="button button-block" name="signup">signup</button>
          
            </form>

        </div>  
        
    </div>
      
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>

</body>
</html>