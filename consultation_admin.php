<?php
    require("verif_admin.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style_accueil.css">
    <link rel="shortcut icon" href="./img/icons8-favicon-16.png" type="image/x-icon">
    <title>Menu admin</title>
</head>
<body>

    <?php
        require('header.php');
    ?>
    
    <section id="zero">
        <article id="left">
            <span>Réseaux et Télécommunications | IUT de Blagnac</span>
            <h2>Bonjour <?php echo $_SESSION["login"]; ?> </h2> <!--Welcome banner-->
            <p>En tant qu'administrateur, vous avez accès à des fonctionnalités avancées pour surveiller et analyser les données en temps réel.</p>
        </article>
    </section>

    <h1>Dynamic Plan</h1>


    <form id="display_history">
        <label for="interval">interval:</label>
        <input type="text" name="interval" id="interval" />
        <button type="submit">Submit</button>
    </form>


    <form action="degradation.php" method="POST"> 
        <p> En utilisant les champs de sélection suivants, indiquez vos paramètres d'estimation. </p>
        <p> Nombre de bits erronés lors de l'envoi : 
            <select name="bits_errones">
                <option value="0">0 bits</option>
                <option value="1">1 bit</option>
                <option value="2">2 bits</option>
            </select>
        </p>
        <p> Nombre de micros en fonction lors de l'envoi : 
            <select name="micros_en_marche">
                <option value="3">3 micros</option>
                <option value="2">2 micros</option>
                <option value="1">1 micro</option>
            </select>
        </p>
        <p> Indiquez la vitesse de déplacement de l'onde sonore : 
            <select name="micros_en_marche">
                <option value="3"> Rapide </option>
                <option value="2"> Moyenne </option>
                <option value="1"> Faible </option>
            </select>
        </p>

        <input type="submit" value="Soumettre">
    </form>

    <div class="consultation">
        <svg id="plan" width="500" height="500"></svg>
    </div>

    <div class="consultation">
        <svg id="plan" width="500" height="500"></svg>
    </div>

    <script src="./scripts/plan.js"></script>

</body>
</html>
