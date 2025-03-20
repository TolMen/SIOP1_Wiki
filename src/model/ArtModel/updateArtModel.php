<?php

/* 
- Inclusion des fichiers nécessaires
*/
require_once '../../control/BDDControl/connectBDD.php';

class UpdateArticleModel
{
    /*
    - Cette fonction récupère les informations des articles
    */
    public function getArticleId(PDO $bdd, $articleId)
    {
        $recupArt = $bdd->prepare('SELECT * FROM article WHERE id = ?');
        $recupArt->execute([$articleId]);
        return $recupArt->fetch(PDO::FETCH_ASSOC);
    }

    /*
    - Fonction pour sauvegarder l'ancienne version de l'article
    */
    public function saveArticleVersion(PDO $bdd, $articleId, $title, $content, $createdAt, $userId, $imageUrl)
    {
        $insertVersion = 'INSERT INTO article_version (title, content, created_at, user_id, article_id, image_url) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $bdd->prepare($insertVersion);
        return $stmt->execute([$title, $content, $createdAt, $userId, $articleId, $imageUrl]);
    }

    /*
    - Fonction pour mettre à jour les informations de l'article
    */
    public function updateArticle(PDO $bdd, $articleId, $title, $content, $userId)
    {
        $updateArt = 'UPDATE article SET title = ?, content = ?, updated_at = NOW(), user_id = ? WHERE id = ?';
        $updateArticle = $bdd->prepare($updateArt);
        return $updateArticle->execute([$title, $content, $userId, $articleId]);
    }

    /* 
    - Fonction pour mettre à jour ou insérer l'image de l'article
    */
    public function updateImage(PDO $bdd, $articleId, $newImageUrl)
    {
        // Vérifie s'il existe déjà une image pour cet article
        $checkImage = $bdd->prepare('SELECT id FROM image WHERE article_id = ?');
        $checkImage->execute([$articleId]);

        // Si une image existe, mise à jour de l'URL de l'image
        if ($checkImage->rowCount() > 0) {
            $updateImage = 'UPDATE image SET url = ?, created_at = NOW() WHERE article_id = ?';
            $stmt = $bdd->prepare($updateImage);
            return $stmt->execute([$newImageUrl, $articleId]);
        }

        // Si aucune image n'existe, insére une nouvelle entrée dans la table images
        $insertImage = 'INSERT INTO image (url, created_at, article_id) VALUES (?, NOW(), ?)';
        $stmt = $bdd->prepare($insertImage);
        return $stmt->execute([$newImageUrl, $articleId]);
    }
}