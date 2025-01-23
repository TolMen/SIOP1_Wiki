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
    <meta name="keywords" content="article, wiki, civilisations, histoire, cultures anciennes, connaissances, partage, gestion de contenu, SLAM, BTS SIO, projet collaboratif, PHP, développement web">
    <meta name="description" content="Page interactive permettant aux utilisateurs de publier des articles sur notre wiki collaboratif.
    Un projet SLAM réalisé dans le cadre du BTS SIO en équipe de 3." />
    <meta name="author" content="Nolan / Kelly / Jessy" />

    <!-- Icône du site -->
    <link rel="icon" type="image/png" sizes="16x16" href="favicon.ico" />

    <!-- Feuilles de style externes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Feuilles de style personnalisées -->
    <link rel="stylesheet" href="css/baseStyle.css">

    <title>Création d'article</title>
</head>

<body>

    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php' ?>

    <!-- Section pour publier un article -->
    <section class="container py-5">
        <h2 class="text-center mb-4">Publier un article</h2>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form method="POST" action="src/control/ArtControl/addArt.php" class="bg-light p-4 rounded shadow">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Entrez le titre de l'article" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Contenu</label>
                        <textarea id="content" name="content" rows="6" class="form-control" placeholder="Écrivez le contenu ici..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="datePublication" class="form-label">Date de publication</label>
                        <input type="date" id="createdAt" name="createdAt" class="form-control" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="publishArticle" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Publier l'article
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Fin de section pour publier un article -->

    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>