<?php

/* 
- Inclusion des fichiers nécessaire
*/
require_once 'src/control/BDDControl/connectBDD.php';

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
}
