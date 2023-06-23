<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GRID - Exemple pour la prochaine SAE">
    <link rel="stylesheet" href="./style/style_gestion.css">
    <link rel="shortcut icon" href="./img/icons8-favicon-16.png" type="image/x-icon">
    <title> Gestion de projet</title>
</head>

<body>
    
    <?php
        require('header.php');
    ?>

    <section id="intro">
        <p>Bienvenue sur la page de gestion de projet ! Cette section regroupe toutes les informations essentielles relatives à notre projet, et en particulier à sa planification.</p> 
    </section>   

    <section id="intro">
        <h2 id='gantt'><a href='#gantt'>Diagramme de Gantt prévisionnel et final</a></h2>
        <p>Voici nos diagrammes de Gantt réalisés à l'aide du logiciel <a href='https://ganttproject.fr.softonic.com/telecharger' target='_blank'>GanttProject</a> :</p>
    </section>

    <section class="contener">
        <div class="blockgest">
            <div class="right">
                <img src='./img/gant-initial.png' id="gantt_prev"  alt='Diagramme de Gantt prévisionnel'>
            </div>
            <div class="left">
                <img id="gantt_fin" src='./img/Gantt-Final-SAE24.png' alt='Diagramme de Gantt final'>
            </div>
        </div>
    </section>

     

    <section id="intro">
        <h2 id='github'><a href='#github'>Outils collaboratifs utilisés</a></h2> 
        <p><a href='https://trello.com/b/KKSacOWL/gestion-projet' target='_blank'>Trello</a> est un outil collaboratif en ligne permettant de créer un ensemble de tableaux, de listes et de tâches réalisées/accomplies, réparties au sein des différents membres du groupe. Cet outil nous permettait de suivre la progression de chacun, veillant à donner une vue d'ensemble claire à nos camarades, tout en nous permettant à nous de garder un cap, individuellement.</p>
        <img src='./img/trello.PNG' alt='Trello '>
    </section> 
    <section id="intro">
        <p><a href='https://github.com/ange-projects/SAE24/' target='_blank'>GitHub</a> est une plateforme de développement logiciel permettant le travail codage collaboratif. Basé sur le système de contrôle de version Git, cet outil nous a permis de travailler localement, de manière indépendante, puis de centraliser l'intégralité de notre travail afin de la partager à nos collègues au sein d'une version cohérente. Cet outil présente des vertus en matière de résolution de conflit puisqu'il permet d'assurer la compatibiltié des différentes parties du projet codées par les différents membres du groupe. A l'aide de la version de bureau GitHub Desktop et de la compatibilité accrue avec l'IDE VSCode, nous avons pû efficacement nous répartir les tâches sans perdre en coordination ni cohérence.</p>
        <img src='./img/github1.png' alt='Repository GitHub'>
    </section>

    <section id="intro">
        <h2 id='perso'><a href='#perso'>Synthèse personnelle de chaque membre</a></h2> 
    </section>
    
    <section id="zero">
        <div class="grid">
            <div class="bloc">
                <h3 id="Pierre"><a href="#Pierre">Pierre CHAVEROUX</a></h3>
                <ul>
                    <h4>Nombre d'heures passées sur le projet</h4>
                    <li>&#8250; 60 h</li>
                    <h4>Problèmes rencontrés</h4>
                    <li>&#8250;  Je n’ai que peu de problèmes au cours de ce projet. Ayant travaillé sur plusieurs aspects de ce dernier, j’ai rencontré le plus de difficulté lors de l’injection des données dans la base de donnée via le script sub_capteur.py. En effet, le format des différents tableaux gérés n’a pas toujours été évident à prendre en compte. Il a en effet fallu adapter de nombreuse fois les tableaux, mais aussi la base de donnée. La modification assez récurrente de cette dernière m’a été assez pénible puisqu'elle m’a obligé à revenir mon travail assez régulièrement. Mes autres missions se sont déroulées sans problème majeur. </li>
                    <h4>Solutions apportées</h4>
                    <li>&#8250; Le problème de formatage des données pour l’envoi dans la BDD aura été réglé avec l’aide de mon camarade Corentin qui m’a aidé à développer des fonctions adaptant les différents tableaux au bon format. En ce qui concerne la conception de la base de donnée, il aura été nécessaire de recentrer le groupe autour de ce sujet pour convenir une fois pour toutes de la structure de cette dernière. Une fois cette mise au point faite, mon travail s’est trouvé facilité. </li>
                    <h4>Notation individuelle des membres du groupe :</h4>
                    <p>Yoann : 5/5 ; Corentin : 5/5 ; Ange : 5/5 ; Gaspard : 5/5</p>
                </ul>
            </div>
            <div class="bloc">
                <h3 id="Ange"><a href="#Ange">Ange GIUNTINI</a></h3>
                <ul>
                    <h4>Nombre d'heures passées sur le projet</h4>
                    <li>&#8250; 60 h</li>
                    <h4>Problèmes rencontrés</h4>
                    <li>&#8250; Ayant décidé de m’orienter principalement vers la programmation web, afin de découvrir la programmation en JavaScript, j’ai rencontré certaines difficultés lors de l’apprentissage de ce langage. En effet, après concertation avec les autres membres du groupe, j'ai décidé de créer un plan dynamique via l'utilisation de la librairie d3.js. Ce choix implique donc l’utilisation de la programmation orientée objet, un concept ne m’éttant pas familier et pour lequel je n’ai reçu que très peu d’enseignement. Créer un programme complexe basé sur ce concept a donc été un défi difficile à relever.</li>
                    <h4>Solutions apportées</h4>
                    <li>&#8250; De sorte à m’informer sur le sujet de la POO et en particulier en JavaScript j’ai participé à de nombreux cours en ligne, notamment ceux de fr.javascript.info que je recommande.</li>
                    <h4>Notation individuelle des membres du groupe :</h4>
                    <p>Pierre : 5/5 ; Corentin : 5/5  ; Yoann: 5/5  ; Gaspard : 5/5</p>
                </ul>
            </div>
            <div class="blocb">               
                <h3 id="Corentin"><a href="#Corentin">Corentin PRADIER</a></h3>
                <ul>
                    <h4>Nombre d'heures passées sur le projet</h4>
                    <li>&#8250; 60 h</li>
                    <h4>Problèmes rencontrés et Solutions apportées</h4>
                    <li>&#8250; L’utilisation de la bibliothèque “struct” permettant la manipulation de données agrégées sous forme binaire comme une séquence d'octets a été complexe au regard du peu de ressources disponibles sur le net. Mais, dans l’ensemble, les avantages des divers langages de programmation et bibliothèques utilisés lors de cette SAÉ ont permis de vous proposer un travail de précision et de qualité.</li>
                    <h4>Notation individuelle des membres du groupe :</h4>
                    <p>Pierre : 5/5 ; Yoann : 5/5 ; Ange : 5/5 ; Gaspard : 5/5</p>
                </ul>
            </div>
            <div class="blocb">
                <h3 id="Gaspard"><a href="#Gaspard">Gaspard BERSOULLÉ</a></h3>
                <ul>
                    <h4>Nombre d'heures passées sur le projet</h4>
                    <li>&#8250; 60 h</li>
                    <h4>Problèmes rencontrés</h4>
                    <li>&#8250; La solution de conteneurisation Docker a rencontré des difficultés sur le Raspberry Pi en raison de l'incompatibilité des conteneurs avec l'architecture ARM v7 32 bits. Cela a empêché l'utilisation efficace de Docker pour partager le code source, héberger la base de données, le site web et le broker MQTT.</li>
                    <h4>Solutions apportées</h4>
                    <li>&#8250;  Hébergement individuel des sites web avec XAMPP : Plutôt que de tenter de mettre en place une solution d'hébergement centralisée avec XAMPP sur le Raspberry Pi.</li>
                    <li>&#8250;  Utilisation de GitHub pour le partage de code : Pour faciliter la collaboration et partager le code source à héberger chacuns de son côté.</li>
                    <li>&#8250;  Hébergement de la base de données sur  sur l'un des PC de l'équipe afin d'avoir tous accès à la même base.</li>
                    <li>&#8250;  Utilisation de Mosquitto directement sur le Raspberry Pi : Plutôt que de passer par des conteneurs Docker pour exécuter Mosquitto, il a été décidé d'installer Mosquitto directement sur le Raspberry Pi. Cela évite les problèmes de compatibilité.</li>

                    
                    <h4>Notation individuelle des membres du groupe :</h4>
                    <p>Pierre : 5/ 5; Corentin : 5/5 ; Ange : 5/5 ; Yoann : 5/5 ; Gaspard : 5/5 </p>
                </ul>
            </div>
            <div class="blocb">
                <h3 id="Yoann"><a href="#Yoann">Yoann FRANCOIS</a></h3>
                <ul>
                    <h4>Nombre d'heures passées sur le projet</h4>
                    <li>&#8250; 60 h</li>
                    <h4>Problèmes rencontrés</h4>
                    <li>&#8250; Insérer problèmes.</li>
                    <h4>Solutions apportées</h4>
                    <li>&#8250; Insérer solutions.</li>
                    <h4>Notation individuelle des membres du groupe :</h4>
                    <p>Pierre : ; Corentin : ; Ange : ; Gaspard :</p>
                </ul>
            </div>
        </div>
    </section>

    <section id="intro">
        <h2>~Synthèse groupée~</h2>
        <h2 id='heur'><a href='#heur'>Heures passées sur le projet : 300</a></h2>
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nous avons commencé à travailler au moment du début des créneaux de cette SAÉ bien que notre attention soit davantage dirigée sur les trois autres SAÉ ces dernières arrivant presque à échéance. Le travail de la semaine 23 était donc centré sur des tâches plus légères que sont la réflexion et la documentation sur les outils que nous allions utiliser ainsi que la réalisation du premier livrable et la fondation de la structure de notre projet (diagramme de flux, fonctionnement des scripts principaux à créer…)
            À partir de la semaine 24, après le passage des SAÉ21 et 23, nous nous sommes mis à temps plein sur la réalisation de la SAÉ24. Regroupés tantôt au sein de l’IUT, tantôt dans un appartement, nous avons enchaîné les séances jusqu’au passage à l’oral, dimanche inclus. Nous estimons le travail abattu à 50h par personne, moyennant quelques variations individuelles : imprévus, travail sur le temps personnel, etc. 
        </p>
        <h2 id='prob'><a href='#prob'>Problèmes rencontrés</a></h2> 
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;De nombreux problèmes furent rencontrés dans la réalisation de ce projet. Le premier d’entre-eux relevait de l’architecture du processeur du Raspberry Pi. En effet, de nombreux problèmes de compatibilité ont dû être résolus, qu’il s’agisse d’images de conteneurs particulières comme de l'impossibilité de configurer un serveur xampp les installeurs ne fonctionnant qu’en 64 bits.
	        Un autre problème rencontré venait de l’apprentissage et de la découverte au moins partielle de certains langages. Le Python et le JavaScript sont au centre de ce problème, en particulier le second pour son côté orienté objet nécessaire à la conception de la grille dynamique au sein de laquelle notre personne simulée se déplace. Ce problème d’apprentissage est en partie de notre faute car nous avons décidé de nous répartir chacun sur nos points faibles de sorte à transmettre nos connaissances aux autres tout en comblant nos propres lacunes.
	        Une autre série de problèmes est liée au manque de planification, notamment en lien avec la dégradation du signal. En effet, nous avons sous-estimé la difficulté engendrée par cette contrainte supplémentaire. Entre la réalisation tardive, les multiples réorientations (manières différentes de dégrader le signal ; approche statistique initiale opposée à l’approche réelle que nous devions simuler), et l’incompatibilité du code, voire des tables précédemment créées, ont demandé plusieurs heures de restructuration tant des scripts que de la base de données.
        </p>
        <h2 id='sol'><a href='#sol'>Solutions apportées</a></h2> 
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;La solution commune à ces différents problèmes s’est avérée être du temps supplémentaire passé sur le projet au global (en lecture de documentation et discussions/réflexions essentiellement.) La communication, l’utilisation de tableaux, de schémas, ou encore d’outils de collaboration : VCS (GitHub), Trello, etc. ont été des pierres angulaires dans la structuration du projet et le dépassement des différentes difficultés énumérées plus haut.
        </p>
        <h2 id='dif'><a href='#dif'>Difficulté ressentie</a></h2> 
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ce projet était de loin le plus difficile après comparaison avec nos camarades des autres groupes. Bien qu’extrêmement formateur de par sa difficulté et le nombre de langages différents utilisés, ce travail s’est avéré harassant, notamment en raison du caractère rapproché des différentes séances. À la lumière du nombre de problèmes rencontrés, nous décidons d’évaluer la difficulté ressentie à 5/5.
        </p>
    </section>

    <section id="intro">
        <h2 id='conclu'><a href='#conclu'>Conclusion</a></h2> 
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cette SAÉ est une expérience formatrice pour l’ensemble du groupe. Nous avons pû renforcer nos compétences sur un large spectre de langages et d’outils. 
	        Nous regrettons seulement de n’avoir pas pû implémenter plus de fonctionnalités et parfaire le projet de la manière dont nous pouvions l’espérer à son commencement.
	        Nous sommes globalement satisfaits, notamment de la synergie et de la coopération au sein du groupe : tout le monde a été productif à son échelle, et la communication fût au centre de notre progression.
        	Nous espérons avoir affaire à davantage de projets de la sorte à l’avenir, en n’oubliant pas cette fois de planifier même les fonctionnalités optionnelles dès le départ du projet ! Nous ressortons malgré tout satisfaits du travail accompli.
        </p>
    </section>
    <script src="script_accueil.js"></script>

    <section id="intro">
        <h2>Timelapse</h2>
        <video width="640" height="360" controls>
             <source src="./img/Short-Timelaps.mp4" type="video/mp4">
        </video>
    </section>
</body>
</html>
