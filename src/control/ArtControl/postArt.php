<?php

/* 
- Inclusion des fichiers nécessaire
*/
require_once 'src/model/ArtModel/postArtModel.php';

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
$imageUrl = $imageData['url'] ?? 'assets/img/civilisation.jpg'; // Image par défaut si aucune image en BDD


if (!empty($articles)) {
    $postArtUser = $articles[0]['user_id']; // On récupère l'ID de l'auteur depuis l'article
    $userArticles = $artPostModel->getPostArtUser($bdd, $postArtUser);
} else {
    throw new Exception("Article non trouvé.");
}


/*
- Boucle pour chaque article récupéré afin de les afficher dans une structure HTML
*/
foreach ($articles as $article) {

    /*
- Vérifier si dateUpdate est null, pour choisir la date à affiché
*/
    $dateToShow = !empty($article['updated_at']) ? $article['updated_at'] : $article['created_at'];
?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 article-container">
                <h2 class="title font-weight-bold border-bottom pb-4 text-center"> <?= htmlspecialchars($article['title']); ?> </h2>

                <!-- Image pour la vue mobile -->
                <div class="text-center d-block d-md-none">
                    <img src="<?= htmlspecialchars($imageUrl) ?>" alt="Image de l'article" class="img-fluid rounded shadow mx-auto d-block mb-3" style="height: 225px; margin: 25px 0">
                </div>

                <div class="text text-center"> <?= nl2br($article['content']); ?> </div>

                <div class="text-muted border-top pt-1">
                    <p class="mb-0 mt-2">Utilisateur : <?= htmlspecialchars($userArticles['username'] ?? 'Inconnu'); ?></p>
                    <p class="mb-0">Publié le : <?= date("d/m/Y", strtotime($dateToShow)); ?></p>
                </div>

                <div class="mt-2">
                    <a href="templateArtV.php?articleVID=<?php echo $postArtId; ?>" class="btn btn-outline-primary btn-sm">Historique</a>
                    <a href="updateArt.php?articleID=<?php echo $postArtId; ?>" class="btn btn-outline-secondary btn-sm">Modification</a>
                </div>
            </div>

            <!-- Image pour la vue desktop -->
            <div class="col-md-4 d-flex justify-content-center d-none d-md-block">
                <div class="sticky-top" style="top: 175px; height: 450px;">
                    <img src="<?= htmlspecialchars($imageUrl) ?>" alt="Image de l'article" class="img-fluid rounded shadow mx-auto d-block">
                </div>
            </div>
        </div>
    </div>
<?php
}
?>