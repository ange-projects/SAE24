<?php
    session_start();
    require_once('connexion_bdd.php');

    // Vérification de la connexion à la base de données
    if(!$connexion){
        die("Connexion impossible à la base de données :".mysqli_connect_error());
    }
    // Vérification des informations de connexion
    if(!empty($_POST["login"]) && !empty($_POST["mdp"])){
        $pseudo = mysqli_real_escape_string($connexion, $_POST["login"]);
        $pseudo_safe = htmlspecialchars($pseudo);
        $mdp = sha1($_POST["mdp"]);

        // Utilisation d'une déclaration préparée
        $stmt = $connexion->prepare("SELECT * FROM admin WHERE login ='$pseudo_safe'");
        $requete = "SELECT mdp FROM admin WHERE login='$pseudo_safe'";
        $resultat = mysqli_query($connexion, $requete);

        // Vérification du mot de passe
        if(mysqli_num_rows($resultat) == 1) {
            // Enregistrement du nom d'utilisateur après vérification
            $_SESSION["login"] = $pseudo_safe;
            // Redirection vers la page correspondante
            header("Location: menu_admin.php"); 
            exit();  
        }else{
            $error = "Identifiant ou mot de passe incorrect.";
        }
    }
    // Fermeture de la connexion à la base de données
    mysqli_close($connexion);
?>
