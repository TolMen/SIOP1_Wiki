<?php

/* 
- Inclusion des fichiers nécessaire
*/
require_once '../../control/BDDControl/connectBDD.php';

class AuthUserModel {

    public function getLoginExist(PDO $bdd, $username) {
        // Vérification du login si existant
        $state = $bdd->prepare("SELECT username FROM user WHERE username = ?");
        $state->execute(array($username));
        return $state->fetch();
    }

    public function getUserInfo(PDO $bdd, $username, $password) {
        $state = $bdd->prepare("SELECT id, username, role FROM user WHERE username = ? AND password = SHA2(?, 256)");
        $state->execute(array($username, $password));
        return $state->fetch();
    }

    public function insertUser(PDO $bdd, $username, $password) {
        $state = $bdd->prepare("INSERT INTO user (username, password, role) VALUES (?, SHA2(?, 256), 'user')");
        $state->execute(array($username, $password));
    }

}
