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
    public function insertArticle(PDO $bdd, $title, $content, $createdAt, $userID, $firstAuthor)
    {
        $insertArt = 'INSERT INTO article (title, content, created_at, user_id, firstAuthor) VALUES (?, ?, ?, ?, ?)';
        $insertArticle = $bdd->prepare($insertArt);
        $insertArticle->execute([$title, $content, $createdAt, $userID, $firstAuthor]);

        return $bdd->lastInsertId();
    }

    public function insertImage(PDO $bdd, $url, $createdAt, $articleID)
    {
        $insertImg = 'INSERT INTO image (url, created_at, article_id) VALUES (?, ?, ?)';
        $insertImage = $bdd->prepare($insertImg);
        return $insertImage->execute([$url, $createdAt, $articleID]);
    }
}
