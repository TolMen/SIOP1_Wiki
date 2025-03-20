<?php

/* 
- Inclusion des fichiers nécessaires
*/
require_once '../../model/ArtModel/updateArtModel.php';
require_once '../../control/BDDControl/connectBDD.php';
require_once '../../model/Services/ImageService.php';

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

    /* 
    - Récupérer l'ancienne URL de l'image
    */
    $oldImageUrl = null;
    $query = $bdd->prepare('SELECT url FROM image WHERE article_id = ? ORDER BY created_at DESC LIMIT 1');
    $query->execute([$articleId]);

    if ($query->rowCount() > 0) {
        $oldImageUrl = $query->fetch(PDO::FETCH_ASSOC)['url'];
    }

    /* 
    - Sauvegarder l'ancienne version de l'article dans la table article_versions
    */
    $updateArticleModel->saveArticleVersion(
        $bdd,
        $articleId,
        $article['title'],
        $article['content'],
        $article['created_at'],
        $article['user_id'],
        $oldImageUrl // Ajoute l'ancienne URL de l'image
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

    // Mise à jour de l'article (sans l'image)
    if ($updateArticleModel->updateArticle($bdd, $articleId, $title, $content, $userId)) {
        // Si une nouvelle image est fournie, mettez-la à jour dans la table images
        if (isset($_FILES['images']) && $_FILES['images']['error'] == 0) {
            // Gestion de l'image (compression, redimensionnement, etc.)
            $uploadDir = '../../../assets/imgUpload/';
            $fileTmpPath = $_FILES['images']['tmp_name'];
            $fileName = $_FILES['images']['name'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($fileExt, $allowedTypes)) {
                echo "Format non supporté.";
                exit;
            }

            $uniqueName = 'imgArticle' . $articleId . '_' . uniqid() . '.' . $fileExt;
            $destPath = $uploadDir . $uniqueName;

            // Compression de l'image
            if (ImageService::compressAndResizeImage($fileTmpPath, $destPath, 800, 800, 75)) {
                $newImageUrl = 'assets/imgUpload/' . $uniqueName;

                // Insertion de l'image dans la table `images`
                if ($updateArticleModel->updateImage($bdd, $articleId, $newImageUrl)) {
                    // Redirection après la mise à jour réussie
                    header('Location: ../../../templateArt.php?articleID=' . $articleId);
                    exit;
                } else {
                    echo "Erreur lors de la mise à jour de l'image.";
                    exit;
                }
            } else {
                echo "Erreur lors de la compression de l'image.";
                exit;
            }
        } else {
            // Redirection si aucune nouvelle image n'est fournie
            header('Location: ../../../templateArt.php?articleID=' . $articleId);
            exit;
        }
    } else {
        echo "Erreur lors de la mise à jour de l'article.";
    }
}
