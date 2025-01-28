<?php

/* 
- Inclusion des fichiers nécessaire
*/
require_once '../../model/ArtModel/addArtModel.php';

if (isset($_POST['publishArticle'])) {

    /*
    - Sécurisation des données
    */
    $title = $_POST['title'];
    $content = $_POST['content'];
    $createdAt = $_POST['createdAt'];

    /*
    - Crée une instance de classe, puis récupère les informations
    */
    $addArticleModel = new AddArticleModel();
    if ($addArticleModel->insertArticle($bdd, $title, $content, $createdAt)) {

        /*
        - Redirection vers le tableau de bord
        */
        header('Location: ../../../home.php');
        throw new Exception("Redirection vers la page d'accueil");
    } else {
        echo "Erreur lors de l'envoi de l'article";
    }
}
