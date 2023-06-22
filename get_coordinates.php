<?php
    require_once("connexion_bdd.php");
    if(isset($_GET['interval'])){
        //store the absolute value of the interval
        $interval = abs($_GET['interval']);
        // Calculate the date and time 30 minutes ago
        $date_start = date('Y-m-d H:i:s', strtotime('-'.$interval.' minutes'));
        $request_content = "SELECT id_mesure FROM coord_points WHERE time >= '$date_start'";
        $SQL_data = mysqli_query($connexion, $request_content);
        $ID_array = [];
        while ($line = mysqli_fetch_assoc($SQL_data)) {
            $ID_array[] = $line['id_mesure'];
        }
    }
    else {
        $request_content = "SELECT id_mesure FROM coord_points ORDER BY id DESC LIMIT 1";
        $SQL_data = mysqli_query($connexion, $request_content);
        $ID_array[0] = mysqli_fetch_assoc($SQL_data)['id_mesure'];
    }
        $list_id = implode(',', $ID_array);
        $request_content = "SELECT x, y FROM coord_points WHERE id_mesure IN ($list_id)";
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
