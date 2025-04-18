<?php

/* 
- Inclusion des fichiers nécessaire
*/
include_once 'src/control/BDDControl/connectBDD.php';

class RecupUserModel {

    public function getUserInfo($bdd) {
        $state = $bdd->prepare("SELECT users.id as userid, username, role, ban.id, ban.user_id FROM users LEFT JOIN ban ON ban.user_id = users.id ORDER BY userid LIMIT 50");
        $state->execute(array());
        return $state->fetchAll();
    }
}