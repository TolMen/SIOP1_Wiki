<?php

/* 
- Inclusion des fichiers nécessaire
*/
require_once 'src/control/BDDControl/connectBDD.php';

class getSearchModel
{

    public function getRecherche(PDO $bdd, $motCle)
    {
         // Préparation et exécution de la requête SQL pour rechercher dans les titres et contenus
    $state = $bdd->prepare("SELECT id, title, content, created_at, updated_at FROM article WHERE title LIKE ? OR content LIKE ? ORDER BY id ");
    $state->execute(['%' . $motCle . '%', '%' . $motCle . '%']);
    $articlesbymotcle = $state->fetchAll();
    return $articlesbymotcle;

    }
}
