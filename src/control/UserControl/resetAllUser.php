<?php

session_name("main");
session_start();
include_once '../BDDControl/connectBDD.php'; // $bdd

if (empty($_SESSION["userID"]) || $_SESSION["userRole"] != "admin") {
    header("Location: javascript://history.go(-1)");
    exit;
}

$bdd->exec(file_get_contents("user.sql"));
header("Location: ../../../home.php");

