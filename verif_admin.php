<?php
    session_start();
    require_once('connexion_bdd.php');
    // Vérification de la connexion à la base de données
    if(!$connexion){
        die("Connexion impossible à la base de données :".mysqli_connect_error());
    }
    /*Role verification to access the admin page*/
    if($_SESSION["login"] != "admin") {
        header("Location: login.php");
        exit();
    }
    mysqli_close($connexion);
?>

