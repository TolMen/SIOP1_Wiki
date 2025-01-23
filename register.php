<?php
session_name("main");
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Inclusion des balise meta -->
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/registerStyle.css" />

    <title>Wiki - Inscription</title>
</head>


<body>
    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php' ?>
    <div class="container">
        <div class=loginPage>
            <form method="POST" action="userlogin.php">
                <label for="identifiantID">Pseudonyme :</label><br>
                <input type="text" value="" id="identifiantID" name="identifiant" /><br>

                <label for="passwordID">Mot de passe :</label><br>
                <input type="password" value="" id="passwordID" name="password" /><br><br>

                <input class=buttonSubmit type="submit" value="S'inscrire" />
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