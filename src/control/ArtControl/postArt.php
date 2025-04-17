<?php

/* 
- Inclusion des fichiers nécessaire
*/
include_once 'src/model/ArtModel/postArtModel.php';
include_once 'src/control/BDDControl/connectBDD.php';

/*
- Vérifie si l'id est passé dans l'URL
*/
if (!empty($_GET['articleID'])) {
    $postArtId = intval($_GET['articleID']);
} else {
    throw new Exception("Identifiant de l'article non spécifié.");
}

/*
- Crée une instance de classe, puis récupère tous les articles par l'appel de fonction
*/
$artPostModel = new ArtPostModel();
$articles = $artPostModel->getPostArt($bdd, $postArtId);
$imageData = $artPostModel->getArticleImage($bdd, $postArtId);
$imageUrl = $imageData['url'] ?? 'assets/img/imgDefault.jpg';


if (!empty($articles)) {
    $postArtUser = $articles[0]['user_id'];
    $postArtFirstUser = $articles[0]['firstAuthor'];
    $userArticles = $artPostModel->getPostArtUser($bdd, $postArtUser);
    $userFirstArticles = $artPostModel->getFirstPostArtUser($bdd, $postArtFirstUser);
} else {
    throw new Exception("Article non trouvé.");
}


/*
- Boucle pour chaque article récupéré afin de les afficher dans une structure HTML
*/
foreach ($articles as $article) {

    /*
- Vérifie si dateUpdate est null, pour choisir la date à affiché
*/
    $dateToShow = !empty($article['updated_at']) ? $article['updated_at'] : $article['created_at'];
?>
    <div class="article-wrapper container">

        <!-- Titre centré au-dessus de tout -->
        <div class="row">
            <div class="col-12">
                <div class="article-header text-center">
                    <h1 class="article-title"><?= htmlspecialchars($article['title']); ?></h1>
                </div>
            </div>
        </div>

        <!-- Image & contenu en ordre responsive -->
        <div class="row">

            <!-- Contenu -->
            <div class="col-lg-8 order-last order-lg-first">
                <div class="article-content">
                    <?= nl2br($article['content']); ?>
                </div>
            </div>


            <!-- Image -->
            <div class="col-lg-4 order-first order-lg-last">
                <div class="article-image-desktop sticky-top z-0">
                    <div class="link mb-3">
                        <a href="templateArt.php?articleID=<?= $article['id']; ?>" class="btn btn-outline-dark btn-sm active">Lire</a>
                        <a href="historique.php?articleID=<?= $article['id']; ?>" class="btn btn-outline-dark btn-sm">Historique</a>
                        <?php if (isset($_SESSION['userID'])) { ?>
                            <a href="updateArt.php?articleID=<?= $postArtId; ?>" class="btn btn-outline-primary btn-sm">Modifier</a>
                        <?php } ?>
                    </div>
                    <img src="<?= htmlspecialchars($imageUrl) ?>" alt="Image de l'article" class="img-fluid rounded shadow">
                    <div class="article-meta mt-3">
                        <p>✏️ Dernière modification par : <strong><?= htmlspecialchars($userArticles['username'] ?? 'Aucune modification'); ?></strong></p>
                        <p>📅 Le : <strong><?= date("d/m/Y à H:i", strtotime($dateToShow)); ?></strong></p>
                        <p>📝 Auteur d’origine : <strong><?= htmlspecialchars($userFirstArticles['username']); ?></strong></p>
                    </div>
                </div>
            </div>
        </div>

    </div>


<?php
}
?>