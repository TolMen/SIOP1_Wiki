<?php

session_name("main");
session_start();

include_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD
include_once 'checkBanned.php'; // Vérification si l'utilisateur est banni
include_once 'src/model/ArtModel/postArtModel.php';

// Préparation la requête pour récupérer tous les articles
$artPostModel = new ArtPostModel();
$articles = $artPostModel->getAllArt($bdd);

// Vérification que des articles sont récupérés
if (empty($articles)) {
    echo "Aucun article trouvé.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Inclusion des balises meta -->
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/homeStyle.css" />

    <title>Civilipédia - Accueil</title>
</head>

<body>

    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php' ?>

    <header class="header">
        <div class="text">
            <h1>Civilipédia</h1>
            <p>Votre source d'informations sur les civilisations du monde.</p>
        </div>
    </header>

    <section class="container my-5">
        <div class="row g-4">
            <?php foreach ($articles as $article) {
                $artPostModel = new ArtPostModel();
                $imageData = $artPostModel->getArticleImage($bdd, $article['id']);
                $imageUrl = $imageData['url'] ?? 'assets/img/imgDefault.jpg';
            ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="templateArt.php?articleID=<?php echo $article['id']; ?>" class="readArt" title="Lire l'article">
                        <div class="article-card">
                            <div class="image_contenu">
                                <img src="<?= htmlspecialchars($imageUrl) ?>" alt="Image de l'article">
                                <?php if (
                                    isset($_SESSION["userRole"], $_SESSION["userID"]) &&
                                    ($_SESSION["userRole"] == "admin" || $_SESSION["userID"] == $article['firstAuthor'])
                                ) { ?>
                                    <a href="src/control/ArtControl/deleteArt.php?articleID=<?php echo $article['id']; ?>" class="delete-badge" title="Supprimer l'article">
                                        <i class="fa-solid fa-trash" style="color: red;"></i>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="content">
                                <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                                <span class="date">
                                    <?= empty($article['updated_at'])
                                        ? date("d/m/Y à H:i", strtotime($article['created_at']))
                                        : date("d/m/Y à H:i", strtotime($article['updated_at'])) ?>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </section>


    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>