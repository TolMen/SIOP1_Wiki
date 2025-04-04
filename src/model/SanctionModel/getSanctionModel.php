<?php

/* 
- Inclusion des fichiers nécessaire
*/
include_once '../../control/BDDControl/connectBDD.php';

class getSanctionModel
{
    public function getBan(PDO $bdd, $reason, $end_date, $user_id)
    {
        $state = $bdd->prepare("INSERT INTO ban (reason, start_date, end_date, user_id) VALUES (?, NOW(), ?, ?)");
        $state->execute(array($reason, $end_date, $user_id));
    }

    public function getUnban(PDO $bdd, $user_id)
    {
        $state = $bdd->prepare("DELETE FROM ban WHERE user_id = ?");
        $state->execute(array($user_id));
    }
}
