<?php

session_name("main");
session_start();
include_once '../BDDControl/connectBDD.php'; // $bdd
include_once '../BDDControl/checkBanned.php'; // Vérification si l'utilisateur est banni
include_once '../../model/UserModel/authUserModel.php';

$username = htmlspecialchars($_POST["username"], ENT_QUOTES);
$password = htmlspecialchars($_POST["password"], ENT_QUOTES);

// Vérification du login si existant
$authUser = new authUserModel();
$verifLogin = $authUser->getLoginExist($bdd, $username);

// Si l'utilisateur n'existe pas
if (empty($user["username"])) {
    // Insertion de l'utilisateur
    $authUser->insertUser($bdd, $username, $password);

    // Récupération des informations de l'utilisateur
    $user = $authUser->getUserInfo($bdd, $username, $password);

    
    $_SESSION["userID"] = $user["id"];
    $_SESSION["userRole"] = $user["role"];
    header("Location: ../../../home.php");
    exit;
}
else {
    // Sinon invalid
    header("Location: ../../../register.php?invalid=True");
}
