<?php
    require("authentification.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style_login.css">
    <link rel="stylesheet" href="./style/style_consult.css">
    <link rel="shortcut icon" href="./img/icons8-favicon-16.png" type="image/x-icon">
    <title>Login</title>
</head>
<body>
    
    <?php
        require('header.php');
    ?>
    
    <section> <!--Login window in glass morphism-->
        <form class="container" name="identification" action="" method="post">
            <p class="accueil">Bienvenue</p>
            <input type="text" name="login" placeholder="Pseudonyme" required><br>
            <input type="password" name="mdp" placeholder="Mot de passe" required><br>
            <input type="submit" name="connexion" value="Connexion"><br>
            <?php
                if(!empty($error)){
                    echo "<p class='erreur'>$error</p>";
                }
            ?>
        </form> <!--If the identification is incorrect, an error message appears-->
    </section>
    
    <script src="script_accueil.js"></script>
    
</body>
</html>