<?php
     $servername="192.168.1.26";
     $username="brulix";
     $password="brul1goat";
     $dbname="bd_micros";
     $mysql_port="3306";

    $connexion = mysqli_connect($servername, $username, $password, $dbname)
        or die("Connexion impossible à la base de données");

// utilisation pierre 
//$servername="localhost";
 //   $username="root";
    //$password="root";
    //$dbname="bd_micros";
    //$mysql_port="3306";

    // $connexion = mysqli_connect($servername, $username, $password, $dbname)
    //     or die("Connexion impossible à la base de données");

    // utilisation ange 
    // $servername="192.168.102.139";
    // $username="passroot";
    // $password="passroot";
    // $dbname="sae21";
    // $mysql_port="3306";
    // $connexion = mysqli_connect($servername, $username, $password, $dbname)
    //     or die("Connexion impossible à la base de données");
?>