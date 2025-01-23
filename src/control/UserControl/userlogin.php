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

// Données BDD
$state = $bdd->prepare("SELECT * FROM users WHERE username = ?");
$state->execute(array($username));
$user = $state->fetch();

// Vérification login
if ($username == $user["username"] && hash("sha256", $password) == $user["password"]) {
    $_SESSION["username"] = $username;
    echo "Oui";
    header("Location: ../../../home.php");
    exit;
}
else {
    $_SESSION["username"] = null;
    echo "Non";
    header("Location: ../../../login.php?wrong=True");
    exit;
}






