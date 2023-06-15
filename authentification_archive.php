<?php
    /*Page en cours de réfection !!!*/

    session_start();
    /*Database connection*/

    require_once('connexion_bdd.php');
    $connexion;

    if(isset($_POST["connexion"])){
        if(!empty($_POST["login"]) && !empty($_POST["mdp"])){

            /*Avoiding SQL and XSS injections*/

            $pseudo = mysqli_real_escape_string($connexion, $_POST["login"]);
            $pseudo_safe = htmlspecialchars($pseudo);
            $mdp = sha1($_POST["mdp"]);

            /*Verification of login and password*/
                $resultat_permission = mysqli_query($connexion, "SELECT mdp FROM admin WHERE login='$pseudo_safe'");
                $requete = "SELECT * FROM admin WHERE login = '$pseudo_safe' AND mdp = '$mdp'";
                $resultat = mysqli_query($connexion, $requete);

            /*Redirection to corresponding pages*/

            if((mysqli_num_rows($resultat) == 1)) {
                header("Location: menu_admin.php"); 
            /*Saves name across sessions*/
                 $_SESSION["login"] = $pseudo_safe;
                exit();  
            } else {
                $error = "Identifiant ou mot de passe incorrect.";
            }
        }
    }
    mysqli_close($connexion);
?>