<?php
    require_once("connexion_bdd.php");
    if(isset($_GET['interval']) && $_GET['interval'] != 0){
        $interval = $_GET['interval'];
        // Calculate the date and time 30 minutes ago
        $date_start = date('Y-m-d H:i:s', strtotime('-'.$interval.' minutes'));
        $request_content = "SELECT id_mesure FROM coordinates WHERE time >= '$date_start'";
        $SQL_data = mysqli_query($connexion, $request_content);
        $ID_array = [];
        while ($line = mysqli_fetch_assoc($SQL_data)) {
            $ID_array[] = $line['id_mesure'];
        }
    }
    else {
        $request_content = "SELECT id_mesure FROM coordinates ORDER BY id DESC LIMIT 1";
        $SQL_data = mysqli_query($connexion, $request_content);
        $ID_array[0] = mysqli_fetch_assoc($SQL_data)['id_mesure'];

        $rand = (rand(0, 1));
        $newID = $ID_array[0] + 1;

        if($rand == 1){
            $x = (rand(0, 7));
            $y = (rand(0, 7));
            $x .= ".25";
            $y .= ".25";
            $publish_content = "INSERT INTO `coordinates` (id_mesure, x, y) VALUES ('$newID','$x', '$y')";
            mysqli_query($connexion, $publish_content);
    
        }
    
        $x = (rand(0, 7));
        $y = (rand(0, 7));
        $x .= ".25";
        $y .= ".25";
    
        $publish_content = "INSERT INTO `coordinates` (id_mesure, x, y) VALUES ('$newID', '$x', '$y')";
        mysqli_query($connexion, $publish_content);
    
    }
        $list_id = implode(',', $ID_array);
        $request_content = "SELECT x, y FROM coordinates WHERE id_mesure IN ($list_id)";
        $SQL_data = mysqli_query($connexion, $request_content);
        $coord = array(
            'x' => array(),
            'y' => array()
        );
        
        while ($line = mysqli_fetch_assoc($SQL_data)) {
            $coord['x'][] = $line['x'];
            $coord['y'][] = $line['y'];
        }
        $coord['id'] = $ID_array;


    mysqli_close($connexion);
    echo json_encode($coord);
?>
