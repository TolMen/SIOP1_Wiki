<?php

session_name("main");
session_start();
require_once '../BDDControl/connectBDD.php'; // $bdd

$username = htmlspecialchars($_POST["username"], ENT_QUOTES);
$password = htmlspecialchars($_POST["password"], ENT_QUOTES);

// Vérification du login si existant
$state = $bdd->prepare("SELECT id, username, password, role FROM user WHERE username = ? AND password = SHA2(?, 256)");
$state->execute(array($username, $password));
$user = $state->fetch();

if ($user["id"]) {
    $_SESSION["userID"] = $user["id"];
    $_SESSION["userRole"] = $user["role"];

    include("../BDDControl/checkBanned.php");

    if ($_SESSION["userRole"] == "admin") {
        header("Location: ../../../dashboard.php");
        exit;
    }

    header("Location: ../../../home.php");
    exit;
}
else {
    header("Location: ../../../login.php?invalid=True");
}
