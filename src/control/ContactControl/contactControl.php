<?php
session_name("main");
session_start();

include_once '../../model/ContactModel/getContactSuccess.php'; // Inclusion du modèle

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et sécurisation des données
    $name = htmlspecialchars($_POST["name"], ENT_QUOTES);
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES);
    $subject = htmlspecialchars($_POST["subject"], ENT_QUOTES);
    $message = htmlspecialchars($_POST["message"], ENT_QUOTES);

    // Instantiation du modèle
    $getInsertinto = new getContactSuccess();
    $getInsertinto->getInsert($bdd, $name, $email, $subject, $message);

    // Récupération des informations pour confirmation
    $getInformation = new getContactSuccess();
    $resultatsforms = $getInformation->getInfo($bdd, $name, $email, $subject, $message);

    // Redirection vers la même page pour afficher la popup avec les informations
    $_SESSION['contact_success'] = true;
    $_SESSION['contact_name'] = $resultatsforms["name"];

    header('Location: ../../../contact.php');
    exit;
}
