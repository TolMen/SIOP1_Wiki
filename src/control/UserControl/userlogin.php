<?php

session_name("main");
session_start();
require_once '../BDDControl/connectBDD.php'; // $bdd

$username = htmlspecialchars($_POST["username"], ENT_QUOTES);
$password = htmlspecialchars($_POST["password"], ENT_QUOTES);

$state = $bdd->prepare("SELECT user.id AS id, username, password, role, ban.id AS is_banned FROM user INNER JOIN ban ON ban.user_id = user.id WHERE username = 'user1'");
$state->execute(array($username));
$user = $state->fetch();

if ($username == $user["username"] && hash("sha256", $password) == $user["password"]) {
    $_SESSION["userID"] = $user["id"];
    $_SESSION["userRole"] = $user["role"];

    $state = $bdd->prepare("");
    $state->execute(array($user["id"]));
    $ban = $state->fetch();

    if (!empty($ban["is_banned"])) {
        header("Location: ../../../login.php?invalid=True");
        exit;
    }

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
