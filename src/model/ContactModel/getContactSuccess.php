<?php

/* 
- Inclusion des fichiers nécessaire
*/
require_once 'src/control/BDDControl/connectBDD.php';

class getContactSuccess{
    public function getInsert(PDO $bdd, $name, $email, $subject, $message){
        $state = $bdd->prepare("INSERT INTO contact(name,email,subject,message) VALUES (?,?,?,?)");
        $state->execute([$name, $email, $subject, $message]);
    }

    public function getInfo(PDO $bdd, $name, $email, $subject, $message){
        $recup = $bdd->prepare("SELECT name, email, subject, message FROM contact WHERE name = ? AND email = ? AND subject = ? AND message = ?");
        $recup->execute([$name, $email, $subject, $message]);
        $resultatsforms = $recup->fetch();
        return $resultatsforms;
    }
}


?>

