<?php

session_name("main");
session_start();
require_once '../BDDControl/connectBDD.php'; // $bdd

// Vérifier si forms non vide
if (!empty($_POST["username"]) && !empty($_POST["password"])) {
    $username = htmlspecialchars($_POST["username"], ENT_QUOTES);
    $password = htmlspecialchars($_POST["password"], ENT_QUOTES);

    // Données users BDD
    $state = $bdd->prepare("SELECT * FROM users WHERE username = ?");
    $state->execute(array($username));
    $user = $state->fetch();

    // Vérifie si le login est bon
    if ($username == $user["username"] && hash("sha256", $password) == $user["password"]) {
        $_SESSION["userID"] = $user["id"];
        $_SESSION["userRole"] = $user["role"];

        // Données bans BDD
        $state = $bdd->prepare("SELECT * FROM bans WHERE user_id = ?");
        $state->execute(array($user["id"]));
        $ban = $state->fetch();


        // Vérifie si l'utilisateur n'est pas banni
        if (empty($ban["id"])) {
            header("Location: ../../../home.php");
            exit;
        }
        else {
            // Sinon denied
            wrongLogin("banned");
        }
    }
    // Sinon denied
    else {
        wrongLogin("wrong_login");
    }
}
else {
    // Sinon denied
    wrongLogin("empty_field");
}

function wrongLogin($denied) {
    $_SESSION["userID"] = null;
    $_SESSION["userRole"] = null;
    header("Location: ../../../login.php?denied=$denied");
    exit;
}





