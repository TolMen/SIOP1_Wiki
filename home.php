<?php

session_start();

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
    <link rel="icon" type="image/png" sizes="16x16" href="favicon.ico" /> <!-- Trouver un favicon -->

    <!-- Feuilles de style externes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Feuilles de style personnalisées -->
    <link rel="stylesheet" href="css/baseStyle.css" />
    <link rel="stylesheet" href="css/homeStyle.css" />

    <title> Civilipédia</title>
</head>

<body>

    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php' ?>

    <section id="presentation_section" class="">
        <div class=" container phrase_accroche">
            <div class="row  ">
                <h1>BIENVENUE </h1>
                <h5>SUR</h5>
                <h2>CIVILIPEDIA</h2>
            </div>
        </div>
    </section>
    <section id="search">
       <div id="search_content">
       <form class="formulaire" method="POST" action="search.php">
            <div class="content_recherche">
                <img src="assets/svg/search.svg" alt="">
                <input type="search" name="mot_cle" id="" placeholder="Entrez un mot-clé" required>
            </div>
            <input class="recherche" type="submit" value="Rechercher" />
        </form>
       </div>

        <div>
            <div class="articles-grid">
                <!-- Article 1 -->
                <div class="article-card">
                    <img src="assets/img/section1background.jpg" alt="Image de l'article">
                    <div class="content">
                        <h3>Nom de l'article</h3>
                        <span class="date">24 août 2023</span>
                        <a href="#" class="read-more">Continuer la lecture </a>
                    </div>
                </div>

            </div>
    </section>

    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>