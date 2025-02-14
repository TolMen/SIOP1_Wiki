<?php

session_name("main");
session_start();
require_once '../BDDControl/connectBDD.php'; // $bdd

// Vérifier si forms non vide
if (!empty($_POST["username"]) && !empty($_POST["password"])) {
    $username = htmlspecialchars($_POST["username"], ENT_QUOTES);
    $password = htmlspecialchars($_POST["password"], ENT_QUOTES);

    // Vérification si login existe déjà
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
        wrongRegister("exists");
    }
}
else {
    // Sinon invalid
    wrongRegister("empty_field");
}

function wrongRegister($invalid) {
    $_SESSION["userID"] = null;
    $_SESSION["userRole"] = null;
    header("Location: ../../../register.php?invalid=$invalid");
    exit;
}
