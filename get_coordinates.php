<?php
    require_once("connexion_bdd.php");
    $request_content = "SELECT id_mesure FROM coord_points ORDER BY id DESC LIMIT 1";
    $SQL_data = mysqli_query($connexion, $request_content);
    $id_mesure = mysqli_fetch_assoc($SQL_data)['id_mesure'];
    
    $request_content = "SELECT x, y FROM coord_points WHERE id_mesure = $id_mesure";
    $SQL_data = mysqli_query($connexion, $request_content);
    $coord = array(
        'x' => array(),
        'y' => array()
    );
    
    while ($line = mysqli_fetch_assoc($SQL_data)) {
        $coord['x'][] = $line['x'];
        $coord['y'][] = $line['y'];
    }

    $rand = (rand(0, 1));
    $newID = $id_mesure + 1;
    if($rand == 1){
        $x = (rand(0, 7));
        $y = (rand(0, 7));
        $x .= ".25";
        $y .= ".25";
        $publish_content = "INSERT INTO `coord_points` (id_mesure, x, y) VALUES ('$newID','$x', '$y')";
        mysqli_query($connexion, $publish_content);

    }

    $x = (rand(0, 7));
    $y = (rand(0, 7));
    $x .= ".25";
    $y .= ".25";

    $publish_content = "INSERT INTO `coord_points` (id_mesure, x, y) VALUES ('$newID', '$x', '$y')";
    mysqli_query($connexion, $publish_content);

    mysqli_close($connexion);


    echo json_encode($coord);
?>
