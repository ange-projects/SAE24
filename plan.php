<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style_consultation.css">
    <link rel="shortcut icon" href="./img/icons8-favicon-16.png" type="image/x-icon">
    <script src="https://d3js.org/d3.v6.min.js"></script>
    <title> Free consultation </title>
</head>
<body>
    
    <?php
        require('header.php');
    ?>

    <h1>Dynamic Plan</h1>

    <div class="consultation">
        <svg id="plan" width="500" height="500"></svg>
    </div>

    <div class="consultation">
        <svg id="plan" width="500" height="500"></svg>
    </div>

    <script src="./scripts/plan.js"></script>
</body>
</html>

