
<?php

session_name("main");
session_start();
require_once '../BDDControl/connectBDD.php'; // $bdd
include_once '../BDDControl/checkBanned.php'; // Vérification si l'utilisateur est banni

if (empty($_SESSION["userID"]) || $_SESSION["userRole"] != "admin") {
    header("Location: javascript://history.go(-1)");
    exit;
}

if (!empty($_SESSION["userID"])) {
    $articleID = htmlspecialchars($_GET["articleID"], ENT_QUOTES);
    $firstAuthorId = $bdd->prepare("SELECT firstAuthor FROM article WHERE id = ?");
    $firstAuthorId->execute(array($articleID));
    $firstAuthorId->fetch();
}

if ($_SESSION["userRole"] == "admin"  ||  $_SESSION["userID"] == $firstAuthorId) {
    $state = $bdd->prepare("DELETE FROM article WHERE id = ?");
    $state->execute(array($articleID));
}

if ($_SESSION["userRole"] == "admin") {
    header("Location: ../../../article_list.php");
} else {
    header("Location: ../../../home.php");
}
