<?php

/* 
- Inclusion des fichiers nécessaire
*/
require_once '../../model/ArtModel/updateArtModel.php';
require_once '../../control/BDDControl/connectBDD.php';

/*
Initialise la classe
*/
$updateArticleModel = new UpdateArticleModel();

/*
- Vérifiez si un ID est en paramètre
*/
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
    */
    $title = $_POST['title'];
    $content = $_POST['content'];

    /*
    - Mise à jour de l'article
    */
    if ($updateArticleModel->updateArticle($bdd, $articleId, $title, $content)) {

        /*
        - Redirection vers le tableau de bord
        */
        header('Location: ../../../templateArt.php?articleID=' . $articleId);
        throw new Exception("Redirection vers la page d'accueil");
    } else {
        echo "Erreur lors de l'envoi de l'article";
    }
}
