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
        $recupArt = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
        $recupArt->execute([$articleId]);
        return $recupArt->fetch(PDO::FETCH_ASSOC);
    }

    /*
    - Fonction pour sauvegarder l'ancienne version de l'article
    */
    public function saveArticleVersion(PDO $bdd, $articleId, $title, $content, $createdAt, $userId, $imageUrl)
    {
        $insertVersion = 'INSERT INTO article_versions (title, content, createdAt, user_id, article_id, image_url) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $bdd->prepare($insertVersion);
        return $stmt->execute([$title, $content, $createdAt, $userId, $articleId, $imageUrl]);
    }

    /*
    - Fonction pour mettre à jour les informations de l'article
    */
    public function updateArticle(PDO $bdd, $articleId, $title, $content, $userId)
    {
        $updateArt = 'UPDATE articles SET title = ?, content = ?, updatedAt = NOW(), user_id = ? WHERE id = ?';
        $updateArticle = $bdd->prepare($updateArt);
        return $updateArticle->execute([$title, $content, $userId, $articleId]);
    }

    // - Fonction pour mettre à jour ou insérer l'image de l'article
    public function updateImage(PDO $bdd, $articleId, $newImageUrl)
    {
        // Vérifier s'il existe déjà une image pour cet article
        $checkImage = $bdd->prepare('SELECT id FROM images WHERE article_id = ?');
        $checkImage->execute([$articleId]);

        // Si une image existe, mettez à jour l'URL de l'image
        if ($checkImage->rowCount() > 0) {
            $updateImage = 'UPDATE images SET url = ?, createdAt = NOW() WHERE article_id = ?';
            $stmt = $bdd->prepare($updateImage);
            return $stmt->execute([$newImageUrl, $articleId]);
        }

        // Si aucune image n'existe, insérer une nouvelle entrée dans la table images
        $insertImage = 'INSERT INTO images (url, createdAt, article_id) VALUES (?, NOW(), ?)';
        $stmt = $bdd->prepare($insertImage);
        return $stmt->execute([$newImageUrl, $articleId]);
    }

}
