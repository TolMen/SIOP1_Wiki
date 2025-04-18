<?php

session_name("main");
session_start();

include_once '../BDDControl/connectBDD.php'; // $bdd
include_once '../../model/ArtModel/deleteArtModel.php';

$articleID = htmlspecialchars($_GET["articleID"], ENT_QUOTES);

$deleteArtProcess = new DeleteArtModel();
$firstAuthorId = $deleteArtProcess->firstAuthorArt($bdd, $articleID);

if ($_SESSION["userRole"] == "admin" || $_SESSION["userID"] == $firstAuthorId["firstAuthor"]) {
    $deleteArtProcess->deleteArt($bdd, $articleID);
}

// Vérifie si la variable HTTP_REFERER est définie
if (isset($_SERVER['HTTP_REFERER'])) {
    // Redirige vers la page précédente
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    // Si HTTP_REFERER n'est pas disponible, redirige vers la page d'accueil par défaut
    header("Location: ../../../home.php");
}
exit;
