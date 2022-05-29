<?php      
include('ClassUser.php');
// a new object is created from the class User
$user = new User();
//validates if the fields are set in, or not empty
if(isset($_POST["UsernameLogin"]) && isset ($_POST["PasswordLogin"])){
    //then we are valdiating again if the fields are filled propertly as we asked in the Registration section
    $errors = $user->validateUser($_POST["UsernameLogin"], $_POST["PasswordLogin"]);

    /* if there is no errors in the fields, then we validate (with the fuction that have the JSON data),
    if the info is already in it or if it is not.*/
    if(empty($errors['uerror']) && empty($errors['perror'])) {
        $errors = $user->userExists($_POST["UsernameLogin"], $_POST["PasswordLogin"]);   
    }
}
?>
<head>
    <!-- Link necessary to inject the font desider-->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <!-- The line is neccesary to inject the CSS file -->
    <link rel='stylesheet' href='FrontEnd.css' type='text/css'>
</head>

<body>
    <div class='backgroundColor'>

        <h1> Welcome to Cuevanna++ </h1>
        <h2> Already registered? Let's start with signing you in</h2>
    </div>
<div class='row'>
    <div class='col col-image'>
        <img class='image' src='Talent.png'>
    </div>
    <div class='col'>
        <p class = 'websitedesc'>Log in with your created account</p>
        <!-- The form pass the info stored in POST to itself -->
        <form class="create" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
            <div class = 'labels'>
                <!-- this error will show if the Username is not like we asked in the Registration section-->
                <div class='error'> <?= $errors['uerror']?></div>
                <!-- this error will show up if the Username field of this Login section is empty-->
                <div class='error'> <?= $errors['nameUserErr']?></div>
                <!-- this message will show up if the user already exists in the JSON file (its registered)-->
                <div> <?= $errors['loggin in']?></div>
                <!-- this message will show up if the Username is not registered yet but the user tries to loggin in-->
                <div> <?= $errors['not registered']?></div>
                <input type='text' class='input1' name='UsernameLogin' placeholder="Your Username" value="<?= $_POST['UsernameLogin']?>">
                
                <!-- this error will show up if the Password is not like we asked in the Registration section-->
                <div class='error'> <?= $errors['perror']?></div>
                <!-- this message will show up if the Password field is empty-->
                <div class='error'> <?= $errors['passUserErr']?></div>
                <input type='password' class='input1' name='PasswordLogin' placeholder="Your Password" value="<?= $_POST['PasswordLogin']?>">
            </div>

            <div class = 'buttons'>
                <input type = 'button' class='input' onclick = 'location.href="PrincipalWeb.php"' value="Register section">
                <input type = 'submit' class='input'  value = 'Log in'>
            </div>
        </form>
    </div>
    <div class='col col-image'>
        <img class='image' src='Movies.png'>
    </div>
</div>
</body>