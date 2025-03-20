<?php

/* 
- Inclusion des fichiers nécessaire
*/
require_once 'src/control/BDDControl/connectBDD.php';

class getHistoriqueModel
{

    public function getHistorique(PDO $bdd, $article_id)
    {

        $state = $bdd->prepare("SELECT article_version.*, user.username AS creator_name 
                        FROM article_version  
                        INNER JOIN user ON user.id = article_version.user_id 
                        WHERE article_version.article_id = ?");
        $state->execute(array($article_id));
        $articlesversion = $state->fetchAll();
        return $articlesversion;
    }
}
