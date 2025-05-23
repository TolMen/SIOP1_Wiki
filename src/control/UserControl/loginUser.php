<?php

session_name("main");
session_start();
include_once '../BDDControl/connectBDD.php'; // $bdd
include_once '../../model/UserModel/authUserModel.php';

$username = htmlspecialchars($_POST["username"], ENT_QUOTES);
$password = htmlspecialchars($_POST["password"], ENT_QUOTES);

$authUser = new authUserModel();
// Récupération des informations de l'utilisateur
$user = $authUser->getUserInfo($bdd, $username, $password);

if (!empty($user)) {
    $_SESSION["userID"] = $user["id"];
    $_SESSION["userRole"] = $user["role"];

    header("Location: ../../../home.php");
    exit;
} else {
    header("Location: ../../../login.php?infoFalse=true");
    exit;
}
