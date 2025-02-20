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
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="mobile-web-app-capable" content="yes" />

        <meta name="keywords" content="###"> 
        <meta name="description" content="### Un projet SLAM réalisé dans le cadre du BTS SIO en équipe de 3." />
        <meta name="author" content="Nolan / Kelly / Jessy" />

        <link rel="icon" type="image/png" sizes="16x16" href="###" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />

        <link rel="stylesheet" href="css/baseStyle.css" />
        <link rel="stylesheet" href="css/dashboardStyle.css" />

        <title>Wiki - Dashboard</title>
    </head>

    <body>
        <?php include 'src/component/navbar.php' ?>

        <div class="container mt-5">
            <h1 class="text-center mb-4">Tableau de Bord</h1>
            <div class="row">
                <div class="col-md-4">
                    <a href="article_list.php" class="card-link">
                        <div class="card dashboard-card">
                            <div class="card-body text-center">
                                <i class="fas fa-newspaper fa-3x"></i>
                                <h5 class="card-title mt-3">Liste des articles</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="user_list.php" class="card-link">
                        <div class="card dashboard-card">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-3x"></i>
                                <h5 class="card-title mt-3">Liste des utilisateurs</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="createArt.php" class="card-link">
                        <div class="card dashboard-card">
                            <div class="card-body text-center">
                                <i class="fas fa-plus fa-3x"></i>
                                <h5 class="card-title mt-3">Créer un articles</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="contact.php" class="card-link">
                        <div class="card dashboard-card logout-card">
                            <div class="card-body text-center">
                                <i class="fas fa-address-book fa-3x"></i>
                                <h5 class="card-title mt-3">Contact</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="home.php" class="card-link">
                        <div class="card dashboard-card logout-card">
                            <div class="card-body text-center">
                                <i class="fas fa-home fa-3x"></i>
                                <h5 class="card-title mt-3">Accueil</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="src/control/UserControl/" class="card-link">
                        <div class="card dashboard-card logout-card">
                            <div class="card-body text-center">
                                <i class="fas fa-sign-out-alt fa-3x"></i>
                                <h5 class="card-title mt-3">Déconnexion</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <?php include 'src/component/footer.php' ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous">
        </script>
    </body>
</html>
