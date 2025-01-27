<?php
session_name("main");
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Inclusion des balise meta -->
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/templateArtStyle.css" />

    <title>
        Article
        <?php
        $artID = intval($_GET['articleID']);
        echo $artID;
        ?>
    </title>
</head>

<body>

    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php' ?>

    <!-- Milieu de page -->
    <section class="infoArticle">
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