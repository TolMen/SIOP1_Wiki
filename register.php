<?php

session_name("main");
session_start();
include_once 'checkBanned.php';

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <!-- Inclusion des balise meta -->
        <?php include 'src/component/head.php'; ?>
        <link rel="stylesheet" href="css/authStyle.css" />
        <title>Wiki - Inscription</title>
    </head>

    <body>
        <!-- Inclusion de la barre de navigation -->
        <?php include 'src/component/navbar.php' ?>

        <div class="container">
            <h1>S'inscrire</h1>
        </div>
        <main class="container">
            <form method="POST" action="src/control/UserControl/userregister.php">
                <label>Pseudonyme :</label><br>
                <input type="text" name="username" minlength="2" maxlength="15" pattern="[a-z0-9._]{2,15}"
                    title="Seules les lettres minuscules, chiffres, '.' et '_' sont autorisés" required /><br>

                <label>Mot de passe :</label><br>
                <input type="password" name="password" required /><br><br>

                <?php if (!empty(htmlspecialchars(!empty($_GET["invalid"]), ENT_QUOTES))) { ?>
                    <label class="invalidCase">Identifiant déjà existant</label><br><br>
                <?php } else { ?>
                    <label></label><br>
                <?php } ?>
                <input type="submit" value="Inscription" />
            </form>
        </main><br>
        <div class="switchAuth">Déjà un compte ?&nbsp;<a href="login.php">Se connecter</a></div>

        <!-- Inclusion du pied de page -->
        <?php include 'src/component/footer.php' ?>

        <!-- Liens vers les scripts JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
            </script>
    </body>

</html>