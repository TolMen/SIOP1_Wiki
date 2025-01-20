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
}
