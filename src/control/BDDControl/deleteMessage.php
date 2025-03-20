
<?php

$messageID = $_GET["id"];

session_name("main");
session_start();
require_once '../BDDControl/connectBDD.php'; // $bdd

if (empty($_SESSION["userID"]) || $_SESSION["userRole"] != "admin") {
    header("Location: javascript://history.go(-1)");
    exit;
}

$query = $bdd->prepare("DELETE FROM contact WHERE id = ?");
$query->execute(array($messageID));

header("Location: ../../../messagerie.php");
exit;
