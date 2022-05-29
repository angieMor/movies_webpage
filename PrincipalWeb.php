<?php
//it is included the file with the class
include('ClassUser.php');
//a new object is created
$user = new User();
//it was necessary this if to make sure that all the fields have info
if(isset($_POST["Username"]) && isset ($_POST["Password"]) && isset($_POST["Email"]) && isset($_POST['Phone'])){
    //it is assigned to a variable, the new object with the desired function to be used
    $errors = $user->validateUser($_POST["Username"], $_POST["Password"], $_POST["Email"], $_POST["Phone"]);
    //if there is no errors available in the array returned,
    if(empty($errors)) {
        //then the user get validated with the fuction newUser, and after that and if it not exists in the JSON, will be
        // stored in the JSON file
        $errors = $user->newUser($_POST["Username"], $_POST["Password"]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Link necessary to inject the font desider-->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <!-- The line is neccesary to inject the CSS file -->
    <link rel='stylesheet' href='FrontEnd.css' type='text/css'>
</head>
<body>
    <div class='backgroundColor'>

        <h1> Welcome to Cuevanna++ </h1>
        <h2> do you want to watch movies and series!?</h2>
    </div>
    <div class='row'>
        <div class='col col-image'>
            <img class='image' src='Talent.png'></img>
        </div>
        <div class='col'>
            <!-- it indicates the user to register-->
            <p class = 'websitedesc'> Want to begin? Let's start with creating your new user </p>
            <!-- this is a message that indicate that the user is already created, and needs to go to the Login section -->
            <span class='error'> <?= $errors['registrated'] ?> </span>
            <!-- There is no errors in the registration fields, so the user is registered now -->
            <span> <?= $errors['success'] ?> </span>
            <!-- The form pass the info stored in POST to itself -->
            <form class="create" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
                <div class = 'labels'>
                    <!-- this is a message error that indicates that the name field doesn't have the required
                    conditions to be a valid username -->
                    <div class='error'> <?= $errors['uerror'] ?> </div>
                    <input type='text' class='input' name='Username' placeholder="Your Username" value="<?= $_POST['Username']?>">
                    
                    <!-- this is a message error that indicates that the password field doesn't have the required
                    conditions to be a valid password -->
                    <div class='error'> <?= $errors['perror'] ?> </div>
                    <input type='password' class='input' name='Password' placeholder="Your Password" value="<?= $_POST['Password']?>">
                    
                    <!-- this is a message error that indicates that the email field doesn't have the required
                    conditions to be a valid email -->
                    <div class='error'> <?= $errors['eerror'] ?> </div>
                    <input type='text' class='input' name='Email' placeholder="Your Email" value="<?= $_POST['Email']?>">
                    
                    <!-- this is a message error that indicates that the phone field doesn't have the required
                    conditions to be a valid phone number -->
                    <div class='error'> <?= $errors['ephone'] ?> </div>
                    <input type='text' class='input' name='Phone' placeholder="Your Phone" value="<?= $_POST['Phone']?>">
                    
                </div>
                <div class = 'buttons'>
                    <input type='submit' class='input' value="Register">
                    <input type='button' class='input' onclick='location.href="Login.php"' value='Log in section'>
                </div>
            </form>
        </div>
        <div class='col col-image'>
            <img class='image2' src='Movies.png'>
        </div>
    </div>
</body>
</html>