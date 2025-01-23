<?php
session_name("main");
session_start();

if (!empty($_GET["wrong"])) {
	$wrong = htmlspecialchars($_GET['wrong'], ENT_QUOTES);
}
else {
    $wrong = null;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Inclusion des balise meta -->
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/registerStyle.css" />
    <link rel="stylesheet" href="css/loginStyle.css" />

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

    <body>
        <!-- Inclusion de la barre de navigation -->
        <?php include 'src/component/navbar.php' ?>

        <div class="container">
            <h1 class="title">S'inscrire</h1>
        </div>
        <div class="container loginPage">
            <form method="POST" action="src/control/UserControl/userregister.php">
                <div class="form-group">
                    <label for="usernameID">Pseudonyme :</label><br>
                    <input type="text" value="" id="usernameID" name="username"/><br>

                    <label for="passwordID">Mot de passe :</label><br>
                    <input type="password" value="" id="passwordID" name="password"/><br><br>
                    <?php
                        if ($wrong != null) {
                            echo "<label class='wrongLogin'>L'Identifiant exise déjà</label><br><br>";
                        }
                    ?>
                </div>

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