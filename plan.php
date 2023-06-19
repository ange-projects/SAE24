<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/consultation.css">
    <link rel="shortcut icon" href="./img/icons8-favicon-16.png" type="image/x-icon">
    <script src="https://d3js.org/d3.v6.min.js"></script>
    <title>Login</title>
</head>
<body>
<header>
        <nav class="navbar"> <!--Navigation bar-->
            <a href="#" class="logo">SAÉ 24 - Estimation de la position d'un objet</a>
            <div class="nav-links">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li class="actif"><a href="plan.php">Consultation</a></li>
                    <li><a href="login.php">Connectez-vous</a></li>
                    <li><a href="gestion.php">Gestion de projet</a></li>
                    <li><a href="mentions.php">Mentions Légales</a></li>
                </ul>
            </div>
        </nav>
</header>
  <h1>Dynamic Plan</h1>

<div class="consultation">
  <svg id="plan" width="500" height="500"></svg>
</div>

<script src="./scripts/plan.js"></script>
</body>
</html>

