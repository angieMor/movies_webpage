<?php

session_start();   //This section will close the account of the user, redirecting him to the Login section
session_destroy();  
header("Location:Login.php");   
exit;

?>