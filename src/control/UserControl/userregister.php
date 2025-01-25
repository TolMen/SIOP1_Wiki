<?php

session_name("main");
session_start();
require_once '../BDDControl/connectBDD.php'; // $bdd

// Vérifier si forms non vide
if (!empty($_POST["username"]) && !empty($_POST["password"])) {
    $username = htmlspecialchars($_POST["username"], ENT_QUOTES);
    $password = htmlspecialchars($_POST["password"], ENT_QUOTES);

    // Vérification si login existe déjà
    $state = $bdd->prepare("SELECT username FROM users WHERE username = ?");
    $state->execute(array($username));
    $user = $state->fetch();

    // Si l'utilisateur n'existe pas
    if (empty($user["username"])) {
        $state = $bdd->prepare("INSERT INTO users (username, password, role) VALUES (?, SHA2(?, 256), 'user')");
        $state->execute(array($username, $password));
        $_SESSION["username"] = $username;
        header("Location: ../../../home.php");
        exit;
    }
    else {
        // Sinon denied
        wrongRegister("exists");
    }

}
else {
    // Sinon denied
    wrongRegister("empty_field");
}

function wrongRegister($denied) {
    $_SESSION["username"] = null;
    echo "Existe, pas ok";
    header("Location: ../../../register.php?denied=$denied");
    exit;
}