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
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="inputBx password">
                    <input type="password" name="mdp" required>
                    <span>Password</span>
                    <i class="fas fa-key"></i>
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
