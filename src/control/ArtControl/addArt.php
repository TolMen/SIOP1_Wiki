<?php

session_name("main");
session_start();

/*
- Inclusion des fichiers nécessaires
*/
require_once '../../model/ArtModel/addArtModel.php';
require_once '../../model/Services/ImageService.php'; // Compression de la taille des images
include_once '../BDDControl/checkBanned.php';

if (isset($_POST['publishArticle'])) {
    /*
    - Sécurisation des données
    */
    $title = $_POST['title'];
    $content = strip_tags($_POST['content'], '<p><b><i><u><strong><em><h1><h2><h3><h4><h5><h6><ol><ul><li><a><img><table><tr><td><th><tbody><thead><tfoot><caption><colgroup><col><pre><code><blockquote><q><hr><br><span><sup><sub><del><ins><mark><video><audio><source><iframe><address><time><article><aside><figcaption><figure><details><summary><kbd>');
    $createdAt = $_POST['createdAt'];
    $userID = $_SESSION['userID'];
    $firstAuthor = $_SESSION['userID'];

    /*
    - Crée une instance de classe, puis récupère les informations
    */
    $addArticleModel = new AddArticleModel();
    $articleID = $addArticleModel->insertArticle($bdd, $title, $content, $createdAt, $userID, $firstAuthor);

    if ($articleID) {
        /*
        - Vérifie si un fichier image est envoyé
        */
        if (isset($_FILES['images']) && $_FILES['images']['error'] == 0) {
            $uploadDir = '../../../assets/imgUpload/'; // Dossier cible

            $fileTmpPath = $_FILES['images']['tmp_name'];
            $fileName = $_FILES['images']['name'];
            $fileSize = $_FILES['images']['size'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif']; // Vérifications des types autorisés

            if (!in_array($fileExt, $allowedTypes)) {
                echo "Format non supporté.";
                exit;
            }

            /*
            - Génére un nom unique avec l'ID de l'article
            */
            $uniqueName = 'imgArticle' . $articleID . '_' . uniqid() . '.' . $fileExt;
            $destPath = $uploadDir . $uniqueName;

            /*
            - Compression et redimensionnement (Max: 800x800, Qualité: 75)
            */
            if (ImageService::compressAndResizeImage($fileTmpPath, $destPath, 800, 800, 75)) {
                $imgUrl = 'assets/imgUpload/' . $uniqueName;
                $addArticleModel->insertImage($bdd, $imgUrl, $createdAt, $articleID);
            } else {
                echo "Erreur lors de la compression de l'image.";
                exit;
            }
        }

        /*
        - Redirection vers le tableau de bord
        */
        header('Location: ../../../templateArt.php?articleID=' . $articleID);
        throw new Exception("Redirection vers la page d'accueil");
    } else {
        echo "Erreur lors de l'envoi de l'article";
    }
}
