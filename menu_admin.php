<?php
    require("verif_admin.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style_menu.css">
    <link rel="stylesheet" href="style/style_grid_gestionnaire.css">
    <link rel="shortcut icon" href="./img/icons8-favicon-16.png" type="image/x-icon">
    <title>Menu admin</title>
</head>
<body>
    <header>
        <nav> <!--Scrolling menu-->
            <ul>
                <li>
                    <a href="#" class="logo">
                        <img src="./img/logo.png" alt="">
                        <span class="nav-item">Administrateur</span>
                    </a>
                </li>
                <li>
                    <a href="index.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 9v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9"/>
                            <path d="M9 22V12h6v10M2 10.6L12 2l10 8.6"/>
                        </svg>
                        <span class="nav-item">Accueil</span>
                    </a>
                </li>
                <li>
                    <a href="login.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle> <!--https://iconsvg.xyz/-->
                        </svg>
                        <span class="nav-item">Portail Gestionnaire</span>
                    </a>
                </li>
                <li>
                    <a href="gestion.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/>
                            <path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/>
                        </svg>
                        <span class="nav-item">Gestion de projet</span>
                    </a>
                </li>
                <li>
                    <a href="mentions.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                            <path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/>
                        </svg>
                        <span class="nav-item">Les mentions légales</span>
                    </a>
                </li>
                <li>
                    <a href="deconnexion.php" class="deconnexion">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"/>
                        </svg>
                        <span class="nav-item">Se déconnecter</span>
                    </a>
                </li>

            </ul>
        </nav>
    </header>
    <section id="zero">
        <article>
            <img id="illustration_gauche" src="./img/temp.PNG" alt="Les données récupérées via nos capteurs.">    
        </article>
        <article id="left">
            <span>Réseaux et Télécommunications | IUT de Blagnac</span>
            <h2>Bonjour <?php echo $_SESSION["login"]; ?> </h2> <!--Welcome banner-->
            <p>En tant qu'administrateur, vous avez accès à des fonctionnalités avancées pour surveiller et analyser les données en temps réel.</p>
        </article>
        <article>
            <img id="illustration_droite" src="./img/support.PNG" alt="Support">    
        </article>
    </section>
</body>
</html>
