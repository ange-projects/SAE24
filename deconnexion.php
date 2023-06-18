<?php

    session_start();
    $_SESSION = array();
    session_destroy(); 
    header('Location: login.php');

    /*Deleting session data and redirecting to the login page*/

?>
