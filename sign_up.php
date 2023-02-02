
<?php
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['age'] = $_POST['age'];
$_SESSION['gender'] = $_POST['gender'];

// Sets user variables.
$first_name =   $_POST['firstname'];        
$last_name = $_POST['lastname'];           
$email = $_POST['email'];                                        
$age = $_POST['age'];                                          
$gender = $_POST['gender'];                                      
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);                                     
$hash =  md5(rand(0, 1000));                                               

// Checks if the email entered already exists.
$result = $mysqli->query("SELECT * FROM user WHERE email='$email'") or die($mysqli->error());

// If the results query contains any matching emails.
if($result->num_rows > 0) {
    $_SESSION['message'] = 'This email already exists.';
    header("location: error.php");
}
else{
    // If email doesn't already exists, insert user data into table.
    $sql = "INSERT INTO user (first_name, last_name, email, age, gender, password, hash) "
            . "VALUES ('$first_name', '$last_name', '$email', '$age', '$gender', '$password', '$hash')";
    
    // Runs the query
    if($mysqli->query($sql)){

        $_SESSION['active'] = 0;
        $_SESSION['logged_in'] = true;
        $_SESSION['message'] =  "A confirmation link has been sent to $email, please verify your account by clicking on the link.";
        
        // Sends the confirmation link email.
        $to = $email;
        $subject = 'Drink Finder Account Verification';
        $message_body = 'Hello '.$first_name.',
        Thank you for registering an account!
        
        Please click this link to activate your account:
        http://localhost:8080/drink_finder/verify.php?email='.$email.'&hash='.$hash;

        mail($to, $subject, $message_body);

        header("location: activate_account.php");

    }
    else{
        $_SESSION['message'] = 'Registration failed.';
        header("location: error.php");
    }
}

?>