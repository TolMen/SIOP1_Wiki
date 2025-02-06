
<?php

session_name("main");
session_start();
require_once '../BDDControl/connectBDD.php'; // $bdd

if (empty($_SESSION["userID"]) || $_SESSION["userRole"] != "admin") {
    header("Location: javascript://history.go(-1)");
    exit;
}

$id = htmlspecialchars($_GET["id"], ENT_QUOTES);
$state = $bdd->prepare("DELETE FROM articles WHERE id = ?");
$state->execute(array($id));

header("Location: ../../../article_list.php");
