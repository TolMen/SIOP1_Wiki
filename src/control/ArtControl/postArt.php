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
    $dateToShow = !empty($article['updatedAt']) ? $article['updatedAt'] : $article['createdAt'];
?>
    <div class="container mt-4">
        <div class="row">
            <!-- Colonne gauche : Article -->
            <div class="col-md-8" style="padding-right: 100px;">
                <h2 class="title font-weight-bold border-bottom pb-4 text-center"> <?= htmlspecialchars($article['title']); ?> </h2>

                <div class="text text-center"> <?= nl2br($article['content']); ?> </div>

                <!-- Signature en bas -->
                <div class="text-muted border-top pt-1">
                    <p class="mb-0 mt-2">Utilisateur : <?= htmlspecialchars($userArticles['username'] ?? 'Inconnu'); ?></p>
                    <p class="mb-0">Publié le : <?= date("d/m/Y", strtotime($dateToShow)); ?></p>
                </div>

                <!-- Liens pour l'historique et la modification -->
                <div class="mt-2">
                    <a href="templateArtV.php?articleVID=<?php echo $postArtId; ?>" class="btn btn-outline-primary btn-sm">Historique</a>
                    <a href="updateArt.php?articleID=<?php echo $postArtId; ?>" class="btn btn-outline-secondary btn-sm">Modification</a>
                </div>
            </div>

            <!-- Colonne droite : Image par défaut qui suit le scroll et reste centrée -->
            <div class="col-md-4 d-flex justify-content-center d-none d-md-block">
                <div class="sticky-top" style="top: 175px; height: 450px;">
                    <img src="assets/img/civilisation.jpg" alt="Image par défaut" class="img-fluid rounded shadow mx-auto d-block">
                </div>
            </div>
        </div>
    </div>
<?php
}
?>