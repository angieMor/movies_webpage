<?php

class User {
    #fuction with 4 parameters that we need to validate
    function validateUser($name, $password, $email='', $phone='') {
        #an empty array was created to storage all the errors that'll be printed in the desired fields of the forms
        $out = [];
        #if the parameter $name is empty, the error will show the user that he have to put the info in this field
        if(empty($name)) { 
            $uerror = 'Please add your Username';
        } else if(!preg_match("/^[a-zA-Z]*$/", $name)) {
            #if the parameter is not empty, the name will only be accepted if it has only letters on it
            $uerror = 'Please add a valid Username: only with letters';
            }
        #if there is an $uerror, then it will be stored in the array $out
        if($uerror){ 
            $out['uerror'] = $uerror;
        }
        /*------------------------------------------*/
        #if the parameter $password is empty, the error will show the user that have to put info in this field
        if(empty($password)) { 
            $perror = 'Please add your Password';
        } else if(!preg_match("/(?=.*[A-Z])/", $password)) {
            #if the parameter is not empty, and if the parameter doesn't have an uppercase letter, it will trigger the message, and password will not be accepted
            $perror = 'Please add a valid Password: with at least 1 uppercase';
            } else if(!preg_match("/(?=.*[*-.])/", $password)) {
                #if the parameter is not empty, and if the parameter doesn't have an special character, it will trigger the message, and password will not be accepted
                $perror = 'Please add a Password with one of these special characters(*-.)';
            } else if(!preg_match("/[A-Za-z\d*-.]{6}/", $password)) {
                #if the parameter is not empty, and if the parameter doesn't have 6 characters, it will trigger the message, and password will not be accepted
                $perror = 'Please add a Password with 6 characters';
            }
        #if there is an $perror, then it will be stored in the array $out
        if($perror) {
            $out['perror'] = $perror;
        }
        /*----------------------------------------------*/
        #if the parameter $email is empty, the error will show the user that have to put info in this field
        if(empty($email)) { 
            $eerror = 'Please add your Email';
        } else if(!preg_match("/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/", $email)) {
            #if the parameter email is not empty, and it contains letters, and a @ and after that a '.' that usually is for the .com, the email will not be accepted
            $eerror = 'Please add a valid Email: with an @ and with ".com"';
        }
        #if there is an $eerror, then it will be stored in the array $out
        if($eerror) {
            $out['eerror'] = $eerror;
        }
        /*-----------------------------------------------*/
        #if the parameter $phone is empty, the error will show the user that have to put info in this field
        if(empty($phone)) { 
            $ephone = "Please add your phone number";
        } else if(!preg_match("/^[+]/", $phone)) {
            #if the parameter is not empty, but it doesn't begin with a '+' it will not be accepted
            $ephone = 'Please add a phone number that begins with +';
        } else if(!preg_match("/\d{9}$/", $phone)) {
            #if the paremeter is not empty, but it doesnt have 9 numbers, it will not be accepted
            $ephone = 'Please add 9 numbers';
        }
        #if there is an $ephone, then it will be stored in the array $out
        if($ephone) {
            $out['ephone'] = $ephone;
        }
        #we will return the content stored in the array $out  
        return $out; 
    }



    #fuction with 2 parameters that we want when a user is creating his User info
    function newUser($name, $password) {   
        #epmty array, used to store some messages for the user
        $out = [];
        $users = array();
        #we are taking the JSON that will store the user's info
        $users = file_get_contents('Database.json');
        #here we had converted the json stored into an associative array, so we can read the names of the user's stored in it
        $users = json_decode($users, true);
        #If the name that the user is trying to register is already in the JSON, it means that the user have already been registered so it's not necessary to register himself again
        if (array_key_exists($name,$users)) {
            $out['registrated'] =  "Username already exist";
        } else {
            #but if the name is not in the JSON, the user and his password will be stored in the JSON and can proceed to the Login area
            $out['success'] = "You've registered succesfully";
            $users[$name] = $password;
            #Line used to store the name and password in the JSON file, and it will be a plain text
            file_put_contents('Database.json', json_encode($users));
        }
        #we will return the array $out so we can know what the user made wrong or right (if it is registered or if the registration is ok)
        return $out;
    }

    #This fuction will be used ONLY when the user is already registered and is trying to fill his info in the fields Username and Password
    function userExists($name, $password) {
        #empty array used to store user errors or succesfull processes
        $out = [];
        #getting the JSON file
        $users = file_get_contents('Database.json', true);
        #and then we are converting in an associative array so it can loop
        $users = json_decode($users, true);
        #if the parameter $name is empty we will ask the user to please type the Username that he had stored previously
        if(empty($name)) {
            $nameUserErr = 'Please type your Username';
            $out['nameUserErr'] = $nameUserErr;
        }
        #if the parameter $password is empty we will ask the user to please type the Password that he had stored previously
        if(empty($password)) { 
            $passUserErr = 'Please type your password';
            $out['passUserErr'] = $passUserErr;
        }
        #we validate if the name of the user is stored in the variable $users(this contains the JSON info)
        if (array_key_exists($name,$users)) {
            /*if the $name of the user and the $name of the user is equal to the $password,
            then the session will start and will take to the user to the actual Movie's Website*/
            if (isset($users[$name]) && $users[$name] == $password){
                $out['loggin in'] =  "Loggin in";
                session_start();    
                $_SESSION['USERDATA']['USERNAME'] = $users[$name];
                header("Location:Movies.php");
                exit();
            }
        } else {
            #if the $name entered by the user doesn't exists in the JSON, the message below will we showed. Because the user haven't registered his user info
            $out['not registered'] = "You're not registered, please go to the Register section";
        }
        #the return will store the errors or success process, and it will show them to the user when the function is called
        return $out;
    }
}
?>