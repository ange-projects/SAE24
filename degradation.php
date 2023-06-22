<?php

    //BDD Connection
    $serveur = "192.168.102.239";
    $utilisateur = "brulix";
    $motDePasse = "brul1goat";
    $nomBase = "bd_micros";

    $connexion = mysqli_connect($serveur, $utilisateur, $motDePasse, $nomBase);

    if (!$connexion) {
       die("Échec de la connexion à la base de données : " . mysqli_connect_error());
    }             

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieving informations from plan.php's form
    // Check if each microphone checkbox is selected
    if (isset($_POST['mic1'])) {
        $micro_actif[] = '1';
    }
    
    if (isset($_POST['mic2'])) {
        $micro_actif[] = '2';
    }
    
    if (isset($_POST['mic3'])) {
        $micro_actif[] = '3';
    }
        $force_mic = $_POST['force_mic'];
        $vitesse = $_POST['vitesse'];
        $micro_actif = implode($micro_actif);
        echo("VALEURS RECUPEREES :");
        var_dump($micro_actif);
        echo($vitesse);
        echo($force_mic);
        // Execution of insertion request
        $requete = "INSERT INTO degradation (micro_actif, force_mic, vitesse) VALUES (?, ?, ?)";
        $statement = mysqli_prepare($connexion, $requete);
        mysqli_stmt_bind_param($statement, 'sii', $micro_actif, $force_mic, $vitesse);
        mysqli_stmt_execute($statement);

        // Verification of execution
        if ($statement) {
            echo "Données insérées avec succès.";
            mysqli_stmt_close($statement);
        } else {
            echo "Erreur lors de l'insertion des données : " . mysqli_error($connexion);
        }
    }

    // Close connection to BDD
    mysqli_close($connexion);
    header('Location: consultation_admin.php');
    exit();

?>