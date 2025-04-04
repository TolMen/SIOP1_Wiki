<?php

session_name("main");
session_start();

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <!-- Inclusion des balise meta -->
        <?php include 'src/component/head.php'; ?>
        <link rel="stylesheet" href="css/authStyle.css" />
        <title>Wiki - Connexion</title>
    </head>

    <body style="padding-top: 55px;">
        <!-- Inclusion de la barre de navigation -->
        <?php include 'src/component/navbar.php' ?>

        <div class="superContent"
            style="margin: 0; padding: 0; min-height: 82vh; display: flex; flex-direction: column;">
            <div class="container">
                <h1>Se connecter</h1>
            </div>
            <main class="container">
                <form method="POST" action="src/control/UserControl/userlogin.php">
                    <div class="form-group">
                        <label>Pseudonyme :</label><br>
                        <input type="text" name="username" minlength="2" maxlength="15" pattern="[a-z0-9._]{2,15}"
                            title="Seules les lettres minuscules, chiffres, '.' et '_' sont autorisés" required /><br>

                        <label>Mot de passe :</label><br>
                        <input type="password" name="password" required /><br><br>

                        <?php if (!empty(htmlspecialchars(!empty($_GET["invalid"]), ENT_QUOTES))) { ?>
                            <label class="invalidCase">Identifiant ou mot de passe invalide</label><br><br>
                        <?php } elseif (htmlspecialchars(!empty($_GET["banned"]), ENT_QUOTES)) { ?>
                            <label class="invalidCase">Utilisateur banni du site</label><br><br>
                        <?php } else { ?>
                            <label></label><br>
                        <?php } ?>
                    </div>
                    <input type="submit" value="Connexion" />
                    <div class="switchAuth">Besoin d'un compte ?&nbsp;<a href="register.php">S'inscrire</a></div>
                </form>
            </main><br>
        </div>

        <!-- Inclusion du pied de page -->
        <?php include 'src/component/footer.php' ?>

        <!-- Liens vers les scripts JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
            </script>
    </body>
</html>