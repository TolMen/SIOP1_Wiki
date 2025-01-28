<?php

/* 
- Inclusion des fichiers nécessaire
*/
require_once '../../model/ArtModel/updateArtModel.php';
require_once '../../control/BDDControl/connectBDD.php';

/*
- Vérifiez si un ID est en paramètre
*/
$updateArticleModel = new UpdateArticleModel(); // Initialiser la classe

if (isset($_GET['articleID'])) {
    $articleId = $_GET['articleID'];
    $article = $updateArticleModel->getArticleId($bdd, $articleId);

    if (!$article) {
        die("Erreur : Article introuvable.");
    }
}

if (isset($_POST['updateArticle'])) {

    /*
    - Sécurisation des données
    - Data security
    */
    $title = $_POST['title'];
    $content = $_POST['content'];
    $updatedAt = $_POST['updatedAt'];

    /*
    - Mise à jour de l'article
    */
    if ($updateArticleModel->updateArticle($bdd, $articleId, $title, $content, $updateAt)) {

        /*
        - Redirection vers le tableau de bord
        */
        header('Location: ../../../home.php');
        throw new Exception("Redirection vers la page d'accueil");
    } else {
        echo "Erreur lors de l'envoi de l'article";
    }
}
