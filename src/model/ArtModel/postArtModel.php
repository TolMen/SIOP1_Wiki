<?php

/* 
- Inclusion des fichiers nécessaire
*/
require_once 'src/control/BDDControl/connectBDD.php';

class ArtPostModel
{

    /*
    - Cette fonction récupère tous les articles par leurs ID
    */
    public function getPostArt(PDO $bdd, $postArtId)
    {
        $recupPostArt = $bdd->prepare('SELECT * FROM articles WHERE id = :id');
        $recupPostArt->execute(['id' => $postArtId]);
        return $recupPostArt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    - Cette fonction récupère le pseudo de l'utilisateur qui a écrit l'article
    */
    public function getPostArtUser(PDO $bdd, $postArtUserId)
    {
        $recupPostArtUser = $bdd->prepare(
            'SELECT username FROM users WHERE id = :id'
        );
        $recupPostArtUser->execute(['id' => $postArtUserId]);
        return $recupPostArtUser->fetch(PDO::FETCH_ASSOC);
    }

    /*
    - Cette fonction récupère l'image de l'article
    */
    public function getArticleImage(PDO $bdd, $articleID)
    {
        $query = $bdd->prepare('SELECT url FROM images WHERE article_id = :article_id LIMIT 1');
        $query->execute(['article_id' => $articleID]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
