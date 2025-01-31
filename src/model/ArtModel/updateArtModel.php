<?php

/* 
- Inclusion des fichiers nécessaires
*/
require_once '../../control/BDDControl/connectBDD.php';

class UpdateArticleModel
{

    /*
    - Cette fonction récupére les informations des articles
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
    public function saveArticleVersion(PDO $bdd, $articleId, $title, $content, $createdAt, $userId)
    {
        $insertVersion = 'INSERT INTO article_versions (title, content, createdAt, user_id, article_id) VALUES (?, ?, ?, ?, ?)';
        $stmt = $bdd->prepare($insertVersion);
        return $stmt->execute([$title, $content, $createdAt, $userId, $articleId]);
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
}
