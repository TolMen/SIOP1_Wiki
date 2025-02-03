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
}
