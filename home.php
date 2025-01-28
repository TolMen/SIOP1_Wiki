<?php
session_name("main");
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Inclusion des balise meta -->
    <?php include 'src/component/head.php'; ?>
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

        <div id="list_art">
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