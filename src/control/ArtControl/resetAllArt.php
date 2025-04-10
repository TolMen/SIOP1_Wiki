<?php

session_name("main");
session_start();
include_once '../BDDControl/connectBDD.php'; // $bdd
include_once '../../model/ArtModel/deleteArtModel.php';

if (empty($_SESSION["userID"]) || $_SESSION["userRole"] != "admin") {
    header("Location: javascript://history.go(-1)");
    exit;
}

$deleteArtProcess = new DeleteArtModel();

if (!empty($_SESSION["userID"])) {
    $articleID = htmlspecialchars($_GET["articleID"], ENT_QUOTES);
}

if ($_SESSION["userRole"] == "admin") {
    $bdd->exec(file_get_contents("article.sql"));
}

if ($_SESSION["userRole"] == "admin") {
    header("Location: ../../../dashboard.php");
} else {
    header("Location: ../../../home.php");
}
