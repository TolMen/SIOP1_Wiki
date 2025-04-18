<?php

/* 
- Inclusion des fichiers nécessaire
*/
include_once 'src/control/BDDControl/connectBDD.php';

class getHistoriqueModel
{

    public function getHistorique(PDO $bdd, $article_id)
    {

        $state = $bdd->prepare("SELECT article_version.*, users.username AS creator_name 
                        FROM article_version  
                        INNER JOIN users ON users.id = article_version.user_id 
                        WHERE article_version.article_id = ?");
        $state->execute(array($article_id));
        $articlesversion = $state->fetchAll();
        return $articlesversion;
    }
}
