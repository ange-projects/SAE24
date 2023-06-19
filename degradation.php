<?php

    //BDD Connection
    $serveur = "192.168.1.78";
    $utilisateur = "brulix";
    $motDePasse = "brul1goat";
    $nomBase = "bd_micros";

    $connexion = mysqli_connect($serveur, $utilisateur, $motDePasse, $nomBase);

    if (!$connexion) {
       die("Échec de la connexion à la base de données : " . mysqli_connect_error());
    }             

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieving informations from plan.php's form
        $bitsErrones = $_POST['bits_errones'];
        $microsEnMarche = $_POST['micros_en_marche'];

        // Execution of insertion request
        $requete = "INSERT INTO degradation (nb_bit, nb_micro) VALUES (?, ?)";
        $statement = mysqli_prepare($connexion, $requete);
        mysqli_stmt_bind_param($statement, 'ii', $bitsErrones, $microsEnMarche);
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
    header('Location: plan.php');
    exit();

?>
