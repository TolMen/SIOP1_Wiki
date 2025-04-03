<?php

session_name("main");
session_start();

/* 
- Inclut le fichier sans afficher son contenu qui est stocké en mémoire tampon et ensuite supprimé
*/
ob_start();
include_once 'src/control/ArtControl/postArt.php';
include_once 'src/control/BDDControl/connectBDD.php';
include_once 'checkBanned.php';
ob_end_clean();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Inclusion des balise meta -->
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/articleStyle.css" />

    <title>
        Article :
        <?= htmlspecialchars($article['title']); ?>
    </title>
</head>

<body>

    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php' ?>
    <!-- Milieu de page -->
    <section class="infoArticle" style="margin: 0; padding: 0; min-height: 82vh; display: flex; flex-direction: column;">
        <?php include 'src/control/ArtControl/postArt.php'; ?>
    </section>
    <!-- Fin du milieu de la page -->

    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>