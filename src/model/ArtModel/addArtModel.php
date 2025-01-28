<?php

/* 
- Inclusion des fichiers nécessaire
*/
require_once '../../control/BDDControl/connectBDD.php';

class AddArticleModel
{

    /*
    - Cette fonction insére les informations des articles
    */
    public function insertArticle(PDO $bdd, $title, $content, $createdAt, $userID)
    {
        $insertArt = 'INSERT INTO articles (title, content, createdAt, user_id) VALUES (?, ?, ?, ?)';
        $insertArticle = $bdd->prepare($insertArt);
        return $insertArticle->execute([$title, $content, $createdAt, $userID]);
    }
}
