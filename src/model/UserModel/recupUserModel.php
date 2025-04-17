<?php

/* 
- Inclusion des fichiers nécessaire
*/
include_once 'src/control/BDDControl/connectBDD.php';

class RecupUserModel {

    public function getUserInfo($bdd) {
        $state = $bdd->prepare("SELECT user.id as userid, username, role, ban.id, ban.user_id FROM user LEFT JOIN ban ON ban.user_id = user.id ORDER BY userid LIMIT 50");
        $state->execute(array());
        return $state->fetchAll();
    }
}