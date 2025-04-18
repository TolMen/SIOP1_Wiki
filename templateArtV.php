<?php
session_name("main");
session_start();

include_once 'src/control/BDDControl/connectBDD.php';
include_once 'checkBanned.php';
include_once 'src/model/ArtModel/postArtModel.php';

$articleVID = intval($_GET['articleVID']);
if ($articleVID <= 0) {
    echo "ID de version invalide.";
    exit;
}

$model = new ArtPostModel();
$articleversion = $model->getArtVersionSpec($bdd, $articleVID);
if (!$articleversion) {
    echo "Version introuvable.";
    exit;
}

// Récupération des infos complémentaires
$imageData = $model->getArticleImage($bdd, $articleversion['article_id']);
$imageUrl = $imageData ? $imageData['url'] : 'assets/default.jpg';

$userArticles = ['username' => $articleversion['creator_name']];
$userFirstArticles = ['username' => $articleversion['first_author_name']];
$dateToShow = $articleversion['created_at'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/styleArticle/artStyle.css" />
    <title>Version de l'article : <?= htmlspecialchars($articleversion['title']); ?></title>
</head>

<body>
    <?php include 'src/component/navbar.php'; ?>

    <section class="main-container">
        <div class="article-wrapper container">
            <!-- Titre -->
            <div class="row">
                <div class="col-12">
                    <div class="article-header text-center">
                        <h1 class="article-title"><?= htmlspecialchars($articleversion['title']); ?></h1>
                    </div>
                </div>
            </div>

            <!-- Contenu + image -->
            <div class="row">
                <!-- Contenu -->
                <div class="col-lg-8 order-last order-lg-first">
                    <div class="article-content">
                        <?= nl2br($articleversion['content']); ?>
                    </div>
                </div>

                <!-- Image + infos -->
                <div class="col-lg-4 order-first order-lg-last">
                    <div class="article-image-desktop sticky-top z-0">
                        <div class="link mb-3">
                            <a href="templateArt.php?articleID=<?= $articleversion['article_id']; ?>" class="btn btn-outline-dark btn-sm">Lire</a>
                            <a href="historique.php?articleID=<?= $articleversion['article_id']; ?>" class="btn btn-outline-dark btn-sm active">Historique</a>
                        </div>
                        <div class="image-wrapper-view">
                            <img src="<?= $articleversion['image_url']; ?>" alt="Image de l'article" class="img-fluid rounded shadow article-image-view">
                        </div>
                        <div class="article-meta mt-3">
                            <p>✏️ Dernière modification par : <strong><?= htmlspecialchars($userArticles['username'] ?? 'Aucune modification'); ?></strong></p>
                            <p>📅 Le : <strong><?= date("d/m/Y à H:i", strtotime($dateToShow)); ?></strong></p>
                            <p>📝 Auteur d’origine : <strong><?= htmlspecialchars($userFirstArticles['username']); ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'src/component/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>