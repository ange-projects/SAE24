<?php
    // generate random  coordinates and publish it one the DB for the tests
    $request_content = "SELECT * FROM coord_points ORDER BY id DESC LIMIT 1";
    $SQL_data = mysqli_query($connexion, $request_content);
    $line = mysqli_fetch_assoc($SQL_data);
    $coord[] = $line['x'];
    $coord[] = $line['y'];
    
    $x = (rand(0, 7));
    $y = (rand(0, 7));

    $x .= ".5";
    $y .= ".5";

    $publish_content = "INSERT INTO `coord_points` (x, y) VALUES ('$x', '$y')";
    mysqli_query($connexion, $publish_content);
    mysqli_close($connexion);
    echo json_encode($coord);
?>