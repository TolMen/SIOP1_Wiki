<?php

session_name("main");
session_start();

// Paramètre denied, message selon le cas
if (!empty($_GET["denied"])) {
	$denied = htmlspecialchars($_GET["denied"], ENT_QUOTES);
    // Si champ(s) vide
    if ($denied == "empty_field") {
        $denied = "Un ou plusieurs champs sont vide";
    }
    // Si utilisateur déjà existant
    elseif ($denied == "exists") {
        $denied = "Identifiant déjà existant";
    }
    // Sinon rien
    else {
        $denied = null;
    }
}
else {
    $denied = null;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Inclusion des balise meta -->
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/baseStyle.css" />
    <link rel="stylesheet" href="css/registerStyle.css" />

    <title>Wiki - Inscription</title>
</head>

<body>
    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php' ?>

    <div class="container">
        <h1 class="title">S'inscrire</h1>
    </div>
    <div class="container registerPage">
        <form method="POST" action="src/control/UserControl/userregister.php">
            <div class="form-group">
                <label for="usernameID">Pseudonyme :</label><br>
                <input type="text" id="usernameID" name="username"/><br>

                <label for="passwordID">Mot de passe :</label><br>
                <input type="password" id="passwordID" name="password"/><br><br>
                <?php
                    // Message denied si non null
                    if ($denied != null) {
                        echo "<label class='badRegister'>$denied</label><br><br>";
                    }
                ?>
            </div>
            <input class=buttonSubmit type="submit" value="S'inscrire" />
        </form>
    </div><br>
    <div>Déjà inscrit ?&nbsp;<a class="otherWayLink" href="register.php">Se connecter</a></div>

    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous">
    </script>
</body>

</html>