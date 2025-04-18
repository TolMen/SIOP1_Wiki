<?php

session_name("main");
session_start();

include_once '../BDDControl/connectBDD.php'; // $bdd
include_once '../../model/ArtModel/deleteArtModel.php';

$articleID = htmlspecialchars($_GET["articleID"], ENT_QUOTES);

$deleteArtProcess = new DeleteArtModel();
$firstAuthorId = $deleteArtProcess->firstAuthorArt($bdd, $articleID);

if ($_SESSION["userRole"] == "admin"  ||  $_SESSION["userID"] == $firstAuthorId["firstAuthor"]) {
    $deleteArtProcess->deleteArt($bdd, $articleID);
}

header("Location: ../../../home.php");
exit;
