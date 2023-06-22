<?php

    require_once('connexion_bdd.php');

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieving informations from plan.php's form


        $degre_deg = $_POST['degre_deg'];
        $vitesse = $_POST['vitesse'];
        if (isset($_POST['mic1'])) {
            $vitesse = $_POST['vitesse'];
        }

        // Check if each microphone checkbox is selected
        if (isset($_POST['mic1'])) {
            $micro_sup[] = '1';
        }

        if (isset($_POST['mic2'])) {
            $micro_sup[] = '2';
        }

        if (isset($_POST['mic3'])) {
            $micro_sup[] = '3';
        }

        $micro_sup = implode($micro_sup);
        echo("VALEURS RECUPEREES :");
        var_dump($micro_sup);
        echo($vitesse);
        echo($degre_deg);

        // Execution of insertion request
        $requete = "INSERT INTO degradation (micro_sup, degre_deg, vitesse) VALUES (?, ?, ?)";
        $statement = mysqli_prepare($connexion, $requete);
        mysqli_stmt_bind_param($statement, 'sii', $micro_sup, $degre_deg, $vitesse);
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