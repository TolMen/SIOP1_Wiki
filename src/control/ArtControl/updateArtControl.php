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

    // Sauvegarder l'ancienne version de l'article dans la table article_versions
    $updateArticleModel->saveArticleVersion(
        $bdd, 
        $articleId, 
        $article['title'], 
        $article['content'], 
        $article['createdAt'], 
        $article['user_id']
    );
}

/*
- Récupère l'ID de l'utilisateur connecté
*/
session_name("main");
session_start();
if (empty($_SESSION['userID'])) {
    die("Utilisateur non connecté.");
}
$userId = $_SESSION['userID'];

/*
- Mise à jour de l'article
*/

if (isset($_POST['updateArticle'])) {

    /*
    - Sécurisation des données
    */
    $title = $_POST['title'];
    $content = strip_tags($_POST['content'], '<p><b><i><u><strong><em><h1><h2><h3><h4><h5><h6><ol><ul><li><a><img><table><tr><td><th><tbody><thead><tfoot><caption><colgroup><col><pre><code><blockquote><q><hr><br><span><sup><sub><del><ins><mark><video><audio><source><iframe><address><time><article><aside><figcaption><figure><details><summary><kbd>');

    /*
    - Mise à jour de l'article
    */
    if ($updateArticleModel->updateArticle($bdd, $articleId, $title, $content, $userId)) {

        /*
        - Redirection vers le tableau de bord
        */
        header('Location: ../../../templateArt.php?articleID=' . $articleId);
        throw new Exception("Redirection vers la page d'accueil");
    } else {
        echo "Erreur lors de l'envoi de l'article";
    }
}
