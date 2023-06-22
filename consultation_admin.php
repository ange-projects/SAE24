<?php
    require("verif_admin.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/admin.css">
    <link rel="shortcut icon" href="./img/icons8-favicon-16.png" type="image/x-icon">

    <title>Menu admin</title>
</head>
<body>

    <?php
        require('header.php');
    ?>
    
    <section id="zero">
        <article id="left">
            <!-- <span>Réseaux et Télécommunications | IUT de Blagnac</span> -->
            <h1>Page d'administration</h1>
            <p>En tant qu'administrateur, vous avez accès à des fonctionnalités avancées pour surveiller et analyser les données en temps réel.</p>
        </article>
    </section>

<div id="globalDiv">

    <div id="plans">
        <div>
            <h2 class="titre_graph">Position réelle</h2>
            <svg id="RealPosition" width="500" height="500"></svg>
        </div>
        <div>
            <h2 class="titre_graph">Position estimée</h2>
            <svg id="plan" width="500" height="500"></svg>
        </div>
    </div>

        <div id="menu">
            <div class="center">
                <h3> Changer la vitesse </h3>
            <br>
            <form id="vitesse" method="POST" action="degradation.php">
                <fieldset id="degrad">
                    <legend>Sélectionner la vitesse de l'objet :</legend>
                    <div>
                        <input type="radio" id="vitesse" name="vitesse" value="3" >
                        <label for="r">Rapide</label>
                    </div>
                    <div>
                        <input type="radio" id="vitesse" name="vitesse" value="2">
                        <label for="m">Moyen</label>
                    </div>
                    <div>
                        <input type="radio" id="vitesse" name="vitesse" value="1"> 
                        <label for="l">Lent</label>
                    </div>
                </fieldset>
                <br>
            <button type="submit" class="submit-button">Submit</button>
            </form>
            <br>
            <h3> Paramètres de dégradation </h3>
            <br>
            <form id="degradation" method="POST" action="degradation.php">
                <input type="radio" id="parfait" name="parfait" value="1" > Conditions parfaites </intput>
                <br>
                <button type="submit" class="submit-button">Submit</button>
            </form>
            <br>
            <button class='accordion' onclick="Show_And_Hide(this.nextElementSibling)">Dégradation</button>
            <form id="degradation" method="POST" action="degradation.php">
                <fieldset id="degrad">
                    <legend>Sélectionner le micro à désactiver :</legend>
                    <div>
                        <input type="radio" id="EnleverMic" name="EnleverMic" value="1">
                        <label for="EnleverMic1">Microphone n°1</label>
                    </div>
                    <div>
                        <input type="radio" id="EnleverMic" name="EnleverMic" value="2">
                        <label for="EnleverMic2">Microphone n°2</label>
                    </div>
                    <div>
                        <input type="radio" id="EnleverMic" name="EnleverMic" value="3">
                        <label for="EnleverMic3">Microphone n°3</label>
                    </div>
                </fieldset>
                <br>
                <button type="submit" class="submit-button">Submit</button>
            </form>
            <br>
            <button class='accordion' onclick="Show_And_Hide(this.nextElementSibling)">Dégradation avancée</button>
            <form id="degradationAvancee" method="POST" action="degradation.php">
                <fieldset id="degrad">
                    <legend>Sélectionner les micros à dégrader :</legend>
                    <div>
                        <input type="checkbox" id="Degrademic1" name="Degrademic1" >
                        <label for="mic1">Microphone n°1</label>
                    </div>
                    <div>
                        <input type="checkbox" id="Degrademic2" name="Degrademic2">
                        <label for="mic2">Microphone n°2</label>
                    </div>
                    <div>
                        <input type="checkbox" id="Degrademic3" name="Degrademic3">
                        <label for="mic3">Microphone n°3</label>
                    </div>
                </fieldset>
                <br>
                <fieldset id="degrad">
                <legend>Sélectionner le nombre de bits à dégrader :</legend>
                    <div>
                        <input type="radio" id="nb_bit_deg" name="nb_bit_deg" value="1" >
                        <label for="Checkmic1">1</label>
                    </div>
                    <div>
                        <input type="radio" id="nb_bit_deg" name="nb_bit_deg" value="2">
                        <label for="Checkmic2">2</label>
                    </div>
                </fieldset>
                <br>
                <fieldset id="degrad">
                    <legend>Sélectionner le degré de dégradation du signal :</legend>
                    <div>
                        <input type="radio" id="fo" name="degre_deg" value="3" >
                        <label for="fo">Fort (2%)</label>
                    </div>
                    <div>
                        <input type="radio" id="mo" name="degre_deg" value="2">
                        <label for="mo">Moyen (0.5%)</label>
                    </div>
                    <div>
                        <input type="radio" id="fa" name="degre_deg" value="1"> 
                        <label for="fa">Faible (0.1%)</label>
                    </div>
                </fieldset>
                <br>
                <button type="submit" class="submit-button">Submit</button>
            </form>
            </div>
            <table>
                <thead>
                    <tr>
                    <th>ID_mesure</th>
                    <th>poids</th>
                    <th>x</th>
                    <th>y</th>
                    <th>time</th>
                    </tr>
                </thead>
                <tbody>
                <!-- Table rows will be dynamically added here -->
                </tbody>
            </table>
        </div>   
    </div>


    <div class="consultation">
        <div id="historique"></div>
            <h1 class="titre_graph">Historique des positions</h1>
            <svg id="history_plan" width="500" height="500"></svg>
            <div class="form">
                <form id="display_history">
                    <h3 class="space_under">Remonter dans le temps : </h3>
                    <span id="intervalDisplay">0 minutes</span>
                    <br>
                    <input type="range" name="interval" id="intervalBar" min="-99999999999" max="0" value="0" oninput="updateValue(this.value)"></input>
                    <br>
                    <button type="submit" class="submit-button">Submit</button>
                </form>
                <br>
                <form id="speed">
                    <h3 class="space_under">Temps de transition entre chaque position :</h3>
                    <span id="speedDisplay">2000 ms</span>
                    <br>
                    <input type="range" name="speed" id="speedBar" min="100" max="5000" value="1000" oninput="GetSpeed(this.value)"></input>
                    <br>
                </form>
            </div>
        </div>
    </div>


<script>
    function updateValue(newValue) {
        document.getElementById("intervalDisplay").textContent = newValue + " minutes";
    }

    function GetSpeed(speed) {
        document.getElementById("speedDisplay").textContent = speed + " ms";
        change_speed(speed);
    }
</script>

    <script src="https://d3js.org/d3.v6.min.js"></script>
    <script src="./scripts/rollDown.js"></script>
    <script src="./scripts/plan.js"></script>
    <script src="./scripts/adminPlan.js"></script>
</body>
</html>
