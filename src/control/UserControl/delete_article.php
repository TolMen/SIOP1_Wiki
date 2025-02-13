
<?php

session_name("main");
session_start();
require_once '../BDDControl/connectBDD.php'; // $bdd

if (empty($_SESSION["userID"]) || $_SESSION["userRole"] != "admin") {
    header("Location: javascript://history.go(-1)");
    exit;
}

if (empty($_SESSION["userID"])){
    $articleID = htmlspecialchars($_GET["articleID"], ENT_QUOTES);
    $firstAuthorId = $bdd->prepare("SELECT firstAuthor FROM articles WHERE id = ?");
    $firstAuthorId->execute(array($articleID));  
    $firstAuthorId->fetch();
}

if(empty($_SESSION["userRole"] == "admin")  ||  (empty($_SESSION["userID"])== $firstAuthorId)){
    $id = htmlspecialchars($_GET["id"], ENT_QUOTES);
    $state = $bdd->prepare("DELETE FROM articles WHERE id = ?");
    $state->execute(array($id));    
}

if(empty($_SESSION["userRole"] != "admin")){
    header("Location: ../../../article_list.php");
}else{
    header("Location: ../../../home.php");  
}
