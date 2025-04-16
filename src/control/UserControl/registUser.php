<?php

session_name("main");
session_start();
include_once '../BDDControl/connectBDD.php'; // $bdd
include_once '../../model/UserModel/authUserModel.php';

$username = htmlspecialchars($_POST["username"], ENT_QUOTES);
$password = htmlspecialchars($_POST["password"], ENT_QUOTES);
$confimPassword = htmlspecialchars($_POST["confirmPassword"], ENT_QUOTES);

// Vérification du login si existant
$authUser = new authUserModel();
$verifLogin = $authUser->getLoginExist($bdd, $username);

if ($verifLogin == false) {
    if ($password == $confimPassword) {
        // Insertion de l'utilisateur
        $authUser->insertUser($bdd, $username, $password);

        // Récupération des informations de l'utilisateur
        $user = $authUser->getUserInfo($bdd, $username, $password);


        $_SESSION["userID"] = $user["id"];
        $_SESSION["userRole"] = $user["role"];
        header("Location: ../../../home.php");
        exit;
    } else {
        header("Location: ../../../register.php?idemPassword=false");
        exit;
    }
} else {
    header("Location: ../../../register.php?loginExist=true");
    exit;
}
