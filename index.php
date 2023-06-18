<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Accueil - SAÉ23">
    <link rel="stylesheet" href="./style/style_accueil.css">
    <link rel="stylesheet" href="./style/style_consult.css">
    <link rel="shortcut icon" href="./img/icons8-favicon-16.png" type="image/x-icon">
    <title>Accueil</title>
</head>

<body>
    <header>
        <nav class="navbar"> <!--Navigation bar-->
            <a href="#" class="logo">SAÉ 24 - Estimation de la position d'un objet</a>
            <div class="nav-links">
                <ul>
                    <li class="actif"><a href="index.php">Accueil</a></li>
                    <li><a href="plan.php">Consultation</a></li>
                    <li><a href="login.php">Connectez-vous</a></li>
                    <li><a href="gestion.php">Gestion de projet</a></li>
                    <li><a href="mentions.php">Mentions Légales</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <section id="intro"> <!--Introduction-->
        <p>
            Bienvenue sur le site de la SAÉ24 !
        </p>
    </section>
    <section id="zero">
        <div class="grid"> <!--Implementation of HTML grid for the aesthetics of the page-->
            <div class="bloc">
                <h3>Objectif du projet</h3>
                <ul>
                <li>&#8250; Exploiter un signal sonore (sinusoïdal) émis par un objet et reçu par trois microphones.</li>
                <li>&#8250; Estimer la position en (x,y) de l’objet dans une pièce.</li>
                <li>&#8250; Présenter l’estimation de la position sur une interface dédiée (site web).</li>
                </ul>
            </div>
            <div class="bloc">
                <h3>Fonctionnalités du Projet</h3>
                <ul>
                    <li>&#8250; Section à éditer</li>
                </ul>
            </div>
            <div class="bloc">
                <h3>Contraintes techniques</h3>
                <ul>
                    <li>&#8250; Environnement : machine virtuelle</li>
                    <li>&#8250; Système d’exploitation : au choix</li>
                    <li>&#8250; Langages autorisés : HTML5, CSS3, PHP, </li>
                    <li>&#8250; Javascript, Bash, C, Python.</li>
                    <li>&#8250; Stockage des données : BD MySQL et/ou InfluxDB</li>
                    <li>&#8250; Codes documentés (commentaires pertinents dans le code) en anglais</li>
                    <li>&#8250; Publication sur un serveur web dédié (xampp)</li>
                    <li>&#8250; Gestion de version via Git et Github</li>
                    
                </ul>
            </div> <!--Building Condition Status-->
        </div>
    </section>
    <script src="script_accueil.js"></script>
</body>

</html>