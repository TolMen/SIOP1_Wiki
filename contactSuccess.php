<?php
session_name("main");
session_start();
require_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD
include_once 'src/control/BDDControl/checkBanned.php'; // Vérification si l'utilisateur est banni

if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["subject"]) && !empty($_POST["message"])) {
    $name = htmlspecialchars($_POST["name"], ENT_QUOTES);
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES);
    $subject = htmlspecialchars($_POST["subject"], ENT_QUOTES);
    $message = htmlspecialchars($_POST["message"], ENT_QUOTES);

    $state = $bdd->prepare("INSERT INTO contact(name,email,subject,message) VALUES (?,?,?,?)");
    $state->execute([$name, $email, $subject, $message]);

    $recup = $bdd->prepare("SELECT name, email, subject, message FROM contact WHERE name = ? AND email = ? AND subject = ? AND message = ?");
    $recup->execute([$name, $email, $subject, $message]);
    $resultatsforms = $recup->fetch();
} else {
    echo "Aucun résultat";
    exit;
}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/contactSuccessStyle.css" />

    <title>Message envoyé</title>
</head>

<body>
    <?php include 'src/component/navbar.php'; ?>
    <div class="container">
        <div class="row">

            <div class="affichage">
                <img src="assets/svg/check-circle.svg" alt="">
                <h1>Merci
                    <?php echo $resultatsforms["name"]; ?> <br>
                    Votre <?php echo $resultatsforms["subject"]; ?> a bien été envoyé!
                </h1>
                <a href="home.php">Retour à l'accueil </a>
            </div>

        </div>
    </div>

    <?php include 'src/component/footer.php'; ?>
</body>

</html>