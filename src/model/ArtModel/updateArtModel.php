<?php

/* 
- Inclusion des fichiers nécessaire
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
    - Fonction pour mettre à jour les informations de l'article
    */
    public function updateArticle(PDO $bdd, $articleId, $title, $content)
    {
        $updateArt = 'UPDATE articles SET title = ?, content = ?, updatedAt = NOW() WHERE id = ?';
        $updateArticle = $bdd->prepare($updateArt);
        return $updateArticle->execute([$title, $content, $articleId]);
    }

}
