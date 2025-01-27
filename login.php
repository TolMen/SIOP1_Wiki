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
    // Si utilisateur banni
    elseif ($denied == "banned") {
        $denied = "Utilisateur banni du site web";
    }
    // Si mauvais login
    elseif ($denied == "wrong_login") {
        $denied = "Identifiant ou mot de passe incorrect";
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
    <link rel="stylesheet" href="css/loginStyle.css" />

    <title>Wiki - Connexion</title>
</head>


<body>
    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php' ?>

    <div class="container">
        <div class=loginPage>
            <form method="POST" action="userlogin.php">
                <label for="identifiantID">Identifiant :</label><br>
                <input type="text" value="" id="identifiantID" name="identifiant" /><br>

                <label for="passwordID">Mot de passe :</label><br>
                <input type="password" value="" id="passwordID" name="password" /><br><br>

        <div class="container">
            <h1 class="title">Se connecter</h1>
        </div>
        <div class="container loginPage">
            <form method="POST" action="src/control/UserControl/userlogin.php">
                <div class="form-group">
                    <label for="usernameID">Identifiant :</label><br>
                    <input type="text" value="" id="usernameID" name="username"/><br>

                    <label for="passwordID">Mot de passe :</label><br>

                    <input type="password" id="passwordID" name="password"/><br><br>
                    <?php
                        // Message denied si non null
                        if ($denied != null) {
                            echo "<label class='badLogin'>$denied</label><br><br>";
                        }
                    ?>
                </div>
                <input class=buttonSubmit type="submit" value="Connexion" />
            </form>
        </div>
    </div>

    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous">
    </script>
</body>

</html>