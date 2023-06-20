<nav class="navbar">
    <a href="#" class="logo">SAÉ 24 - Estimation de la position d'un objet</a>
    <div class="nav-links">
	<ul>
		<li><a id="acc_js" href="index.php"> Accueil </a></li>
        <li><a id="gest_js" href="gestion.php"> Gestion de projet </a></li>
        <li><a id="men_js" href="mentions.php"> Mentions légales </a></li>
        <?php
		    if (session_status() == PHP_SESSION_NONE) {
			    session_start();
		    }
		
            // Check if the user is logged in
		    if (isset($_SESSION['login']) && $_SESSION['login'] == 'admin') {
			    echo '<li><a href="consultation_admin.php"> Full Consultation </a>';
                echo '<li><a href="deconnexion.php">Déconnexion</a></li>';
		    } else {
                echo '<li><a href="plan.php">Free Consultation</a></li>';
			    echo '<li><a href="login.php">Se connecter</a></li>';
		    }
		?>
	</ul>
    </div>
</nav>