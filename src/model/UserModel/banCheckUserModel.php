<?php  

require_once 'src/control/BDDControl/connectBDD.php';

class banCheckUserModel {

    public function checkUserBan(PDO $bdd, $userID) {
        $querybanned = $bdd->prepare("SELECT id FROM ban WHERE user_id = ?");
        $querybanned->execute(array($userID));
        return $querybanned->fetch();
    }

    public function getInfoUserBan(PDO $bdd, $userID) {
        $state = $bdd->prepare("SELECT * FROM ban WHERE user_id = ? ORDER BY start_date LIMIT 1");
        $state->execute(array($userID));
        return $state->fetch();
    }

}