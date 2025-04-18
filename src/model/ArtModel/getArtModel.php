<?php

/* 
- Inclusion des fichiers nécessaire
*/
include_once 'src/control/BDDControl/connectBDD.php';

class GetArtModel
{

    /*
    - Cette fonction récupère les informations des articles
    */
    public function getArticleId(PDO $bdd, $articleId) {
        $recupArt = $bdd->prepare('SELECT *, image.url FROM article LEFT JOIN image ON article_id = article.id WHERE article.id = ?');
        $recupArt->execute([$articleId]);
        return $recupArt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFiltredArticles($bdd, $id, $mots_cles, $user_id) {
        $query = $bdd->prepare("SELECT id, title, user_id, created_at, updated_at FROM article WHERE id LIKE ? AND title LIKE ? AND content LIKE ? AND user_id LIKE ? ORDER BY id LIMIT 50");
        $query->execute(array($id, $mots_cles, $mots_cles, $user_id));
        return $query->fetchAll();
    }


}
