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
    
    echo json_encode($coord);
?>
