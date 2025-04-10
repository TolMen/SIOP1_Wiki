<?php

session_name("main");
session_start();

include_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD
include_once 'checkBanned.php'; // Vérification si l'utilisateur est banni

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/styleContact/styleContactForm.css" />

    <title>Wiki - Contact</title>
</head>

<body>
    <?php include 'src/component/navbar.php'; ?>

    <div class="main-container">
        <div class="box">
            <form method="POST" action="contactSuccess.php">
                <h2>Contactez-nous</h2>

                <div class="boxIdentity">
                    <div class="inputBox inputBoxIdentity">
                        <input type="text" id="name" name="name" minlength="2" maxlength="15" pattern="[A-Za-z0-9._]{2,15}" required />
                        <span>Nom</span>
                        <i></i>
                    </div>

                    <div class="inputBox inputBoxIdentity">
                        <input type="email" id="email" name="email" required />
                        <span>Email</span>
                        <i></i>
                    </div>
                </div>

                <div class="inputBox inputBoxOther full-width margeBottom">
                    <input type="text" id="subject" name="subject" minlength="2" required />
                    <span>Objet</span>
                    <i></i>
                </div>

                <div class="inputBox inputBoxOther full-width">
                    <textarea id="message" name="message" minlength="5" required></textarea>
                    <span class="spanTextarea">Message</span>
                </div>

                <input type="submit" name="envoi" value="Envoyer">
            </form>
        </div>
    </div>

    <?php include 'src/component/footer.php'; ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>