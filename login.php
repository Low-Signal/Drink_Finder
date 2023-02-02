<?php
// Sets the variables to be used.
$email = $_POST['email'];
$result = $mysqli->query("SELECT *FROM user WHERE email='$email'");

// If there is no matching email, return an error.
if($result->num_rows == 0)
{
    $_SESSION['message'] = "No user with that email exists.";
    header("location: error.php");
}
else{
    $user = $result->fetch_assoc();     // Takes the result and stores it into a user array

    // Checks if the password matches, if it does set the session variables.
    if(password_verify($_POST['password'], $user['password']))
    {
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['age'] = $user['age'];
        $_SESSION['gender'] = $user['gender'];
        $_SESSION['active'] = $user['active'];

        $_SESSION['logged_in'] = true;
        header("location: activate_account.php");
    }
    else {
        $_SESSION['message'] = " Invalid password, try again.";
        header("location: error.php");
    }
}
?>