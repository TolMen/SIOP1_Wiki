<?php

session_name("main");
session_start();
require_once '../BDDControl/connectBDD.php'; // $bdd

// Vérifier si forms non vide
if (!empty($_POST["username"]) && !empty($_POST["password"])) {
    $username = htmlspecialchars($_POST["username"], ENT_QUOTES);
    $password = htmlspecialchars($_POST["password"], ENT_QUOTES);
}
else {
    $username = null;
    $password = null;
}

// Vérification si login existe déjà
$state = $bdd->prepare("SELECT username FROM users WHERE username = ?");
$state->execute(array($username));
$user = $state->fetch();

if (empty($user["username"])) {
    echo "N'existe pas";
    $state = $bdd->prepare("INSERT INTO users (username, password, role) VALUES ('?', SHA2('?', 256), 'user')");
    $state->execute(array($username), array($password));
    $user = $state->fetch();
    $_SESSION["username"] = $username;
    header("Location: ../../../home.php");
    exit;
}
else {
    $_SESSION["username"] = null;
    echo "Existe";
    header("Location: ../../../register.php?wrong=True");
    exit;
}






