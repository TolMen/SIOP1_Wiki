<?php

/* 
- Inclusion des fichiers nécessaire
*/
include_once 'src/control/BDDControl/connectBDD.php';

class RecupUserModel {

    public function getUserInfo(PDO $bdd, $isBanned, $id, $username, $role) {
        $query = "SELECT user.id as userid, username, role, ban.id, ban.user_id FROM user LEFT JOIN ban ON ban.user_id = user.id WHERE user.id LIKE ? AND username LIKE ? AND role LIKE ?";

        if ($isBanned == "True") {
            $query = $query . " AND ban.id IS NOT NULL";
        } elseif ($isBanned == "False") {
            $query = $query . " AND ban.id IS NULL";
        }

        $query = $query . " ORDER BY userid LIMIT 50;";

        $state = $bdd->prepare($query);
        $state->execute(array($id, $username, $role));
        return $state->fetchAll();
    }
}