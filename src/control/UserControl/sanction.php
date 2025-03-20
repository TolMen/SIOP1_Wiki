<?php

session_name("main");
session_start();
require_once '../BDDControl/connectBDD.php'; // $bdd

if (empty($_SESSION["userID"]) || $_SESSION["userRole"] != "admin") {
    header("Location: javascript://history.go(-1)");
    exit;
}

$user_id = htmlspecialchars($_GET["user_id"], ENT_QUOTES);
$method = htmlspecialchars($_GET["method"], ENT_QUOTES);

if (!empty($_POST["reason"]))
    $reason = htmlspecialchars($_POST["reason"], ENT_QUOTES);
else {
    $reason = null;
}

if (!empty($_POST["end_date"]))
    $end_date = htmlspecialchars($_POST["end_date"], ENT_QUOTES);
else {
    $end_date = null;
}

if ($method == "ban") {
    $state = $bdd->prepare("INSERT INTO ban (reason, start_date, end_date, user_id) VALUES (?, NOW(), ?, ?)");
    $state->execute(array($reason, $end_date, $user_id));
}

if ($method == "unban") {
    $state = $bdd->prepare("DELETE FROM ban WHERE user_id = ?");
    $state->execute(array($user_id));
}

header("Location: ../../../user_list.php");
