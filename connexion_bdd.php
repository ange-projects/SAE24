<?php
    $servername="192.168.102.239";
    $username="brulix";
    $password="brul1goat";
    $dbname="bd_micros";
    $mysql_port="3306";

    $connexion = mysqli_connect($servername, $username, $password, $dbname)
        or die("Connexion impossible à la base de données");

        // utilisation ange 
    // $servername="192.168.102.133";
    // $username="passroot";
    // $password="passroot";
    // $dbname="sae21";
    // $mysql_port="3306";
    // $connexion = mysqli_connect($servername, $username, $password, $dbname);

?>