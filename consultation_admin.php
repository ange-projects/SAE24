<?php
    require("verif_admin.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style_consultation.css">
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
    <svg id="RealPosition" width="500" height="500"></svg>

    <svg id="plan" width="500" height="500"></svg>
    <div class="degradation">
        <div class="center">
            <h3> Paramètres de dégradation </h3>
            <form id="degradation" method="POST" action="degradation.php">
                <fieldset id="degrad">
                    <legend>Sélectionner le(s) micro(s) à dégrader :</legend>
                    <div>
                        <input type="checkbox" id="mic1" name="mic1" value="1" >
                        <label for="mic1">Microphone n°1</label>
                    </div>
                    <div>
                        <input type="checkbox" id="mic2" name="mic2" value="2">
                        <label for="mic2">Microphone n°2</label>
                    </div>
                    <div>
                        <input type="checkbox" id="mic3" name="mic3" value="3">
                        <label for="mic3">Microphone n°3</label>
                    </div>
                </fieldset>
                <br>
                <fieldset id="degrad">
                    <legend>Sélectionner le degré de dégradation du signal :</legend>
                    <div>
                        <input type="radio" id="fo" name="force_mic" value="3" >
                        <label for="fo">Fort (2%)</label>
                    </div>
                    <div>
                        <input type="radio" id="mo" name="force_mic" value="2">
                        <label for="mo">Moyen (0.5%)</label>
                    </div>
                    <div>
                        <input type="radio" id="fa" name="force_mic" value="1"> 
                        <label for="fa">Faible (0.1%)</label>
                    </div>
                </fieldset>
                <br>
                <fieldset id="degrad">
                    <legend>Sélectionner la vitesse de l'objet :</legend>
                    <div>
                        <input type="radio" id="r" name="vitesse" value="3" >
                        <label for="r">Rapide</label>
                    </div>
                    <div>
                        <input type="radio" id="m" name="vitesse" value="2">
                        <label for="m">Moyen</label>
                    </div>
                    <div>
                        <input type="radio" id="l" name="vitesse" value="1"> 
                        <label for="l">Lent</label>
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


    <div class="consultation">
        <svg id="history_plan" width="500" height="500"></svg>
        <div class="form">
            <form id="display_history">
                <h3 class="space_under">Remonter dans le temps : </h3>
                <span id="intervalDisplay">0 minutes</span>
                <br>
                <input type="range" name="interval" id="intervalBar" min="-500" max="0" value="0" oninput="updateValue(this.value)"></input>
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
    <script src="./scripts/plan.js"></script>
    <script src="./scripts/history.js"></script>
</body>
</html>
