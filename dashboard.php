
<?php

session_name("main");
session_start();

// Vérifier si non connecté ou non admin, si oui, revenir à la page précédente
if (empty($_SESSION["userID"]) || $_SESSION["userRole"] != "admin") {
    header("Location: javascript://history.go(-1)");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <!-- Balises méta essentielles -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="mobile-web-app-capable" content="yes" />

        <!-- Informations SEO -->
        <meta name="keywords" content="###"> <!-- Mettre des mots clés -->
        <meta name="description" content="###
        Un projet SLAM réalisé dans le cadre du BTS SIO en équipe de 3." /> <!-- Mettre une description -->
        <meta name="author" content="Nolan / Kelly / Jessy" />

        <!-- Icône du site -->
        <link rel="icon" type="image/png" sizes="16x16" href="###" /> <!-- Trouver un favicon -->

        <!-- Feuilles de style externes -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />

        <!-- Feuilles de style personnalisées -->
        <link rel="stylesheet" href="css/baseStyle.css" />
        <link rel="stylesheet" href="css/dashboardStyle.css" />

        <title>Wiki - Dashboard</title>
    </head>

    <body>
        <!-- Inclusion de la barre de navigation -->
        <?php include 'src/component/navbar.php' ?>

        <!-- Code -->
        <a href="article_list.php">Liste des articles</a>
        <a href="user_list.php">Liste des utilisateurs</a>
        <a href="src/control/UserControl/logout.php">Se déconnecter</a>

        <!-- Inclusion du pied de page -->
        <?php include 'src/component/footer.php' ?>

        <!-- Liens vers les scripts JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous">
        </script>
    </body>
</html>
