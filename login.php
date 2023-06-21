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
    <link rel="shortcut icon" href="./img/icons8-favicon-16.png" type="image/x-icon">
    <title>Login</title>
</head>
<body>
    
    <?php
        require('header.php');
    ?>
    
    <section>
        
        <div class="box">
        <div class="container"> 
            <div class="form"> 
            <h2>Bienvenue</h2>
            <form name="identification" action="" method="post">
                <div class="inputBx">
                    <input type="text" name="login" required>
                    <span>Login</span>
                    <svg class="fas fa-user-circle" height="1em" viewBox="0 0 512 512"><style>svg{fill:#ffffff}</style><path d="M406.5 399.6C387.4 352.9 341.5 320 288 320H224c-53.5 0-99.4 32.9-118.5 79.6C69.9 362.2 48 311.7 48 256C48 141.1 141.1 48 256 48s208 93.1 208 208c0 55.7-21.9 106.2-57.5 143.6zm-40.1 32.7C334.4 452.4 296.6 464 256 464s-78.4-11.6-110.5-31.7c7.3-36.7 39.7-64.3 78.5-64.3h64c38.8 0 71.2 27.6 78.5 64.3zM256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-272a40 40 0 1 1 0-80 40 40 0 1 1 0 80zm-88-40a88 88 0 1 0 176 0 88 88 0 1 0 -176 0z"/></svg>
                </div>
                <div class="inputBx password">
                    <input type="password" name="mdp" required>
                    <span>Password</span>
                    <svg class="fas fa-key" height="1em" viewBox="0 0 512 512"><path d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z"/></svg>
                </div>
                <div class="inputBx">
                    <input type="submit" name="connexion" value="Connexion"> 
                </div>
                <?php
            if(!empty($error)){
                echo "<p class='erreur'>$error</p>";
            }
            ?>
            </form>
            </div>
        </div>
          
        </div>
    </section>
      
    
    <script src="script_accueil.js"></script>
    
</body>
</html>
