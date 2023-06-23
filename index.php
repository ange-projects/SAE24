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
    
    <?php
        require('header.php');
    ?>

    <section id="intro"> <!--Introduction-->
        <p>
            Bienvenue sur le site de la SAÉ24 !
        </p>
    </section>
    
    <section class="zero">
        <div class="grid"> <!--Implementation of HTML grid for the aesthetics of the page-->
            <div class="bloc">
                <h3>Objectif du projet</h3>
                <ul class="index_dale">
                <li>&#8250; Exploiter un signal sonore (sinusoïdal) émis par un objet et reçu par trois microphones.</li>
                <li>&#8250; Estimer la position en (x,y) de l’objet dans une pièce.</li>
                <li>&#8250; Présenter l’estimation de la position sur une interface dédiée (site web).</li>
                </ul>
            </div>

            <div class="bloc">
                <h3>Contraintes techniques</h3>
                <ul class="index_dale">
                    <li>&#8250; Environnement : machine virtuelle</li>
                    <li>&#8250; Système d’exploitation : Raspbian</li>
                    <li>&#8250; Langages autorisés : HTML5, CSS3, PHP, Javascript, Python</li>
                    <li>&#8250; Stockage des données : BD MySQL</li>
                    <li>&#8250; Codes documentés en anglais</li>
                    <li>&#8250; Publication sur un serveur web dédié    </li>
                    <li>&#8250; Gestion de version via Git et Github</li>
                    
                </ul>
            </div> <!--Building Condition Status-->
        </div>
    </section>

    <section class="zero">
        <div class="bloc">
                <h3>Fonctionnalités du Projet</h3>
                <div class="bloc">
                    <img id="img_chart" src="./img/flow_chart.png" alt="coucou" title="Flow chart   de la solution SAE24"> 
                </div>
                <div class="bloc">
                    <img id="img_fonctionnement" src="./img/sfonctionnement.png" alt="coucou" title="Schéma de fonctionnement de la solution SAE24"> 
                </div>
       </div>
    </section>

    <script src="script_accueil.js"></script>
    
</body>

</html>