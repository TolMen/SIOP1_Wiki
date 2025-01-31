<?php

session_name("main");
session_start();

/* 
- Inclusion des fichiers nécessaire
*/
require_once '../../model/ArtModel/addArtModel.php';

if (isset($_POST['publishArticle'])) {

    /*
    - Sécurisation des données
    */
    $title = $_POST['title'];
    $content = strip_tags($_POST['content'], '<p><b><i><u><strong><em><h1><h2><h3><h4><h5><h6><ol><ul><li><a><img><table><tr><td><th><tbody><thead><tfoot><caption><colgroup><col><pre><code><blockquote><q><hr><br><span><sup><sub><del><ins><mark><video><audio><source><iframe><address><time><article><aside><figcaption><figure><details><summary><kbd>');
    $createdAt = $_POST['createdAt'];
    $userID = $_SESSION['userID'];

    /*
    - Crée une instance de classe, puis récupère les informations
    */
    $addArticleModel = new AddArticleModel();
    if ($addArticleModel->insertArticle($bdd, $title, $content, $createdAt, $userID)) {

        /*
        - Redirection vers le tableau de bord
        */
        header('Location: ../../../home.php');
        throw new Exception("Redirection vers la page d'accueil");
    } else {
        echo "Erreur lors de l'envoi de l'article";
    }
}
