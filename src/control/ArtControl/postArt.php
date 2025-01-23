<?php

/* 
- Inclusion des fichiers nécessaire
*/
require_once 'src/model/ArtModel/postArtModel.php';

/*
- Vérifie si l'id est passé dans l'URL
*/
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $postArtId = intval($_GET['id']);
} else {
    throw new Exception("Identifiant de l'article non spécifié.");
}

/*
- Crée une instance de classe, puis récupère tous les articles par l'appel de fonction
*/
$artPostModel = new ArtPostModel();
$articles = $artPostModel->getPostArt($bdd, $postArtId);
/*
- Boucle pour chaque article récupéré afin de les afficher dans une structure HTML
*/
foreach ($articles as $article) {
    /*
- Vérifier si dateUpdate est null, pour choisir la date à affiché
*/

    $dateToShow = !empty($article['updated_at']) ? $article['updated_at'] : $article['created_at'];
?>
    <h2 class="title"><?= htmlspecialchars($article['title']); ?></h2>
    <i class="separator"></i>
    <div class="littleInfo">
        <p class="author">Ecrit par l'utilisateur n°<?= htmlspecialchars($article['user_id']); ?></p>
        <p class="date"><?= date("d/m/Y", strtotime($dateToShow)); ?></p>
    </div>
    <i class="separator"></i>
    <p class="text"><?= nl2br(htmlspecialchars($article['content'])); ?></p>
<?php
}
?>