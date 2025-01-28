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

/*
- Boucle pour chaque article récupéré afin de les afficher dans une structure HTML
*/
foreach ($articles as $article) {

/*
- Vérifier si dateUpdate est null, pour choisir la date à affiché
*/
    $dateToShow = !empty($article['updatedAt']) ? $article['updatedAt'] : $article['createdAt'];
?>
    <h2 class="title"><?= htmlspecialchars($article['title']); ?></h2>
    <i class="separator"></i>
    <div class="littleInfo">
        <p class="author">Ecrit par l'utilisateur n°<?= htmlspecialchars($article['user_id']); ?></p>
        <p class="date"><?= date("d/m/Y", strtotime($dateToShow)); ?></p>
    </div>
    <div class="link">
        <a href="templateArtV.php?articleVID=<?php echo $postArtId; ?>">Historique</a>
        <span> - </span>
        <a href="updateArt.php?articleID=<?php echo $postArtId; ?>">Modification</a>
    </div>
    <i class="separator"></i>
    <p class="text"><?= nl2br(htmlspecialchars($article['content'])); ?></p>
<?php
}
?>