<?php

session_name("main");
session_start();
require_once '../BDDControl/connectBDD.php'; // $bdd
include '../BDDControl/checkBanned.php'; // Vérification si l'utilisateur est banni
$username = htmlspecialchars($_POST["username"], ENT_QUOTES);
$password = htmlspecialchars($_POST["password"], ENT_QUOTES);

// Vérification du login si existant
$state = $bdd->prepare("SELECT username FROM user WHERE username = ?");
$state->execute(array($username));
$user = $state->fetch();

// Si l'utilisateur n'existe pas
if (empty($user["username"])) {
    $state = $bdd->prepare("INSERT INTO user (username, password, role) VALUES (?, SHA2(?, 256), 'user')");
    $state->execute(array($username, $password));
    $_SESSION["userID"] = $user["id"];
    $_SESSION["userRole"] = $user["role"];
    header("Location: ../../../home.php");
    exit;
}
else {
    // Sinon invalid
    header("Location: ../../../register.php?invalid=True");
}
