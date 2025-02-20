<?php

session_name("main");
session_start();
require_once '../BDDControl/connectBDD.php'; // $bdd

$username = htmlspecialchars($_POST["username"], ENT_QUOTES);
$password = htmlspecialchars($_POST["password"], ENT_QUOTES);

$state = $bdd->prepare("SELECT id, username, password, role FROM user WHERE username = ? AND password = ?");
$state->execute(array($username, hash("sha256", $password)));
$user = $state->fetch();

if ($user["id"]) {
    $_SESSION["userID"] = $user["id"];
    $_SESSION["userRole"] = $user["role"];

    include("../BDDControl/checkBanned.php");

    if ($_SESSION["userRole"] == "admin") {
        header("Location: ../../../dashboard.php");
        exit;
    }

    header("Location: ../../../homed.php");
    exit;
}

else {
    header("Location: ../../../login.php?invalid=True");
}
