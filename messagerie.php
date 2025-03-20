<?php

session_name("main");
session_start();
require_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD

if (!empty($_SESSION["userID"]) && $_SESSION["userRole"] == "admin") {
    $query = $bdd->prepare("SELECT name, email, subject, message FROM contact");
    $query->execute(array());
    $messages = $query->fetchAll();
} else {
    header("Location: javascript://history.go(-1)");
    exit;
}


?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php include 'src/component/head.php'; ?>
        <link rel="stylesheet" href="css/messagerie.css" />

        <title>Wiki - Messagerie</title>
    </head>

    <body>
        <!-- <?php include 'src/component/navbar.php'; ?> -->
        <div class="container">
            <?php foreach ($messages as $message) { ?>
                <div class="row">
                    <div class="message">
                        <h4>De : <?php echo $message["name"]; ?></h4>
                        <h6>Email : <?php echo $message["email"]; ?></h6>
                        <h6>Sujet : <?php echo $message["subject"]; ?></h6><br>
                        <p><?php echo $message["message"]; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>

        <?php include 'src/component/footer.php'; ?>
    </body>

</html>