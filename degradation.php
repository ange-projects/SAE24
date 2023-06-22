<?php

    require_once('connexion_bdd.php');

    // Retrieving informations from plan.php's form
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Check if 'EnleverMic' is set
        $micro_sup = isset($_POST['EnleverMic']) ? $_POST['EnleverMic'] : 0;

        // Check if each microphone checkbox is selected
        $micros_mod = array();
        $micros_mod[] = isset($_POST['Degrademic1']) ? '1' : 0;
        $micros_mod[] = isset($_POST['Degrademic2']) ? '2' : 0;
        $micros_mod[] = isset($_POST['Degrademic3']) ? '3' : 0;

        $micros_mod = implode('', $micros_mod);

        // Set the default value to 0 if 'bit' is not set
        $nb_bit_deg = isset($_POST['nb_bit_deg']) ? $_POST['nb_bit_deg'] : 0;

        // Set the default value to 0 if 'degre_deg' is not set
        $degre_deg = isset($_POST['degre_deg']) ? $_POST['degre_deg'] : 0;

        // $statement = mysqli_prepare($connexion, $requete);
        
        // Set the default value to 0 if 'vitesse' is not set
        $vitesse = isset($_POST['vitesse']) ? $_POST['vitesse'] : null;
        
        // if the user requests perfect conditions
        if (isset($vitesse)){
            $requete = "UPDATE degradation SET vitesse = $vitesse ORDER BY id DESC LIMIT 1";
        }
        elseif (isset($_POST['parfait'])) {
            echo  "0, $micro_sup, $micros_mod, $nb_bit_deg, $degre_deg";
            $requete = "UPDATE degradation SET methode = 0, micro_sup = 0, micro_mod = 0, nb_bit_deg = 0, degre_deg = 0";
        } elseif ($micro_sup == 0) {
            echo  "2, $micros_mod, $nb_bit_deg, $degre_deg";
            $requete = "INSERT INTO degradation SET methode = 2, micro_mod = $micros_mod, nb_bit_deg = $nb_bit_deg, degre_deg = $degre_deg, micro_sup = 0";
        } else {
            $requete = "INSERT INTO degradation SET methode = 1, micro_mod = 0, nb_bit_deg = 0, degre_deg = 0, micro_sup = $micro_sup";
        }
        echo $requete;
        // $result = mysqli_query($connexion, $requete);


    }
    // Close connection to BDD
    mysqli_close($connexion);
    header('Location: consultation_admin.php');
    exit();

?>