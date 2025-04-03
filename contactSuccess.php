<?php

session_name("main");
session_start();

include_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD
include_once 'checkBanned.php'; // Vérification si l'utilisateur est banni
include_once 'src/model/ContactModel/getContactSuccess.php';

$name = htmlspecialchars($_POST["name"], ENT_QUOTES);
$email = htmlspecialchars($_POST["email"], ENT_QUOTES);
$subject = htmlspecialchars($_POST["subject"], ENT_QUOTES);
$message = htmlspecialchars($_POST["message"], ENT_QUOTES);

$getInsertinto = new getContactSuccess();
$getInsertinto->getInsert($bdd, $name, $email, $subject, $message) ;

$getInformation = new getContactSuccess();
$resultatsforms = $getInformation->getInfo($bdd, $name, $email, $subject, $message);

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php include 'src/component/head.php'; ?>
        <link rel="stylesheet" href="css/contactSuccessStyle.css" />

        <title>Wiki - Message envoyé</title>
    </head>

    <body>
        <?php include 'src/component/navbar.php'; ?>
        <div class="container">
            <div class="row">
                <div class="affichage">
                    <img src="assets/svg/check-circle.svg" alt="">
                    <h1>Merci <?php echo $resultatsforms["name"]; ?> <br> Votre message a bien été envoyé!</h1>
                    <a href="home.php">Retour à l'accueil </a>
                </div>
            </div>
        </div>

        <?php include 'src/component/footer.php'; ?>
    </body>
</html>