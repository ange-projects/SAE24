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
            <h2>Bonjour <?php echo $_SESSION["login"]; ?> </h2> <!--Welcome banner-->
            <p>En tant qu'administrateur, vous avez accès à des fonctionnalités avancées pour surveiller et analyser les données en temps réel.</p>
        </article>
    </section>


    <div class="consultation">
        <svg id="plan" width="500" height="500"></svg>
        <div class="center">
    <h3> Paramètres de dégradation </h3>
    <form method="POST" action="degradation.php">
        <fieldset>
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
        <fieldset>
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
        <fieldset>
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
<!--                <p> Nombre de bits erronés : 
                    <select name="bits_errones">
                        <option value="0">0 bits</option>
                        <option value="1">1 bit</option>
                        <option value="2">2 bits</option>
                    </select>
                </p>
                <p> Nombre de micros en fonction  : 
                    <select name="micros_en_marche">
                        <option value="3">3 micros</option>
                        <option value="2">2 micros</option>
                        <option value="1">1 micro</option>
                    </select>
                </p>
                <p> Vitesse de déplacement de l'objet:
            <select name="micros_en_marche">
                <option value="3"> Rapide </option>
                <option value="2"> Moyenne </option>
                <option value="1"> Faible </option>
            </select>
                </p>
                <br>
                <button type="submit" class="submit-button">Submit</button>
            </form>-->
    </div>
    </div>

    <div class="consultation">
        <svg id="history_plan" width="500" height="500"></svg>
        <div class="center">
            <h3>Remonter dans le temps : </h3>
            <span id="intervalValue">0</span>
            <form id="display_history">
            <input type="range" name="interval" id="interval" min="-500" max="0" value="0" oninput="updateValue(this.value)">
            <br>
            <button type="submit" class="submit-button">Submit</button>
             </form>
        </div>
    </div>

    <script>
        function updateValue(newValue) {
            document.getElementById("intervalValue").textContent = newValue + " minutes";
        }
    </script>

    <script src="https://d3js.org/d3.v6.min.js"></script>
    <script src="./scripts/plan.js"></script>
    <script src="./scripts/history.js"></script>
</body>
</html>
