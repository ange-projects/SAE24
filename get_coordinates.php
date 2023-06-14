<?php

    $servername="192.168.160.45";
    $username="passroot";
    $password="passroot";
    $dbname="sae21";
    $mysql_port="3306";
    $connexion = mysqli_connect($servername, $username, $password, $dbname);

    // generate random  coordinates and publish it one the DB for the tests
    $request_content = "SELECT * FROM coordinates ORDER BY id DESC LIMIT 1";
    $SQL_data = mysqli_query($connexion, $request_content);

    $line = mysqli_fetch_assoc($SQL_data);
    $coord[] = $line['x'];
    $coord[] = $line['y'];

    $x = (rand(0, 8));
    $y = (rand(0, 8));

    $publish_content = "INSERT INTO `coordinates` (x, y) VALUES ('$x', '$y')";
    mysqli_query($connexion, $publish_content);
    echo json_encode($coord);
?>