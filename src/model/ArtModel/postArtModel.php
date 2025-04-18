<?php

/* 
- Inclusion des fichiers nécessaire
*/
include_once 'src/control/BDDControl/connectBDD.php';

class ArtPostModel
{

    /*
    - Cette fonction récupère tous les articles par leurs ID
    */
    public function getPostArt(PDO $bdd, $postArtId)
    {
        $recupPostArt = $bdd->prepare('SELECT * FROM article WHERE id = :id');
        $recupPostArt->execute(['id' => $postArtId]);
        return $recupPostArt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    - Cette fonction récupère le pseudo de l'utilisateur qui a modifié l'article
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
    - Cette fonction récupère le pseudo de l'utilisateur qui a écrit l'article
    */
    public function getFirstPostArtUser(PDO $bdd, $postArtUserId)
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
        $query = $bdd->prepare('SELECT url FROM image WHERE article_id = :article_id LIMIT 1');
        $query->execute(['article_id' => $articleID]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getArtVersionSpec(PDO $bdd, $articleVID)
    {
        $state = $bdd->prepare("SELECT article_version.*, u1.username AS first_author_name, u2.username AS creator_name FROM article_version JOIN article ON article_version.article_id = article.id JOIN users u1 ON article.firstAuthor = u1.id JOIN users u2 ON article_version.user_id = u2.id WHERE article_version.id = ?;
");
        $state->execute(array($articleVID));
        return $state->fetch();
    }

    public function getAllArt(PDO $bdd) {
        $state = $bdd->prepare("SELECT * FROM article ORDER BY id DESC");
        $state->execute();
        return $state->fetchAll();
    }
}
