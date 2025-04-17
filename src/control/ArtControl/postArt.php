<?php
include_once 'src/model/ArtModel/postArtModel.php';
include_once 'src/control/BDDControl/connectBDD.php';

if (!empty($_GET['articleID'])) {
    $postArtId = intval($_GET['articleID']);
} else {
    throw new Exception("Identifiant de l'article non spécifié.");
}

$artPostModel = new ArtPostModel();
$articles = $artPostModel->getPostArt($bdd, $postArtId);
$imageData = $artPostModel->getArticleImage($bdd, $postArtId);
$imageUrl = $imageData['url'] ?? 'assets/img/imgDefault.jpg';

if (!empty($articles)) {
    $article = $articles[0]; // juste un article ici
    $postArtUser = $article['user_id'];
    $postArtFirstUser = $article['firstAuthor'];
    $userArticles = $artPostModel->getPostArtUser($bdd, $postArtUser);
    $userFirstArticles = $artPostModel->getFirstPostArtUser($bdd, $postArtFirstUser);

    $dateToShow = !empty($article['updated_at']) ? $article['updated_at'] : $article['created_at'];
} else {
    throw new Exception("Article non trouvé.");
}
