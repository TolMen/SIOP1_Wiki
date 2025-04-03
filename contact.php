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
    <link rel="stylesheet" href="css/contactStyle.css" />

    <title>Wiki - Contact</title>
</head>

<body style="padding-top: 55px;">
    <?php include 'src/component/navbar.php'; ?>

    <section id="presentation_section">
        <div class="contact_content">
            <div class="line-content">
                <div class="line"></div>
                <span>Contactez nous</span>
                <div class="line"></div>
            </div>
        </div>

        <div class="container content">
            <div class="row col-sm-4 col-md-6 col-lg-4">
                <div>
                    <form action="contactSuccess.php" method="post">
                        <label for="name">Nom :</label>
                        <input type="text" id="name" name="name" placeholder="Votre nom" minlength="2" maxlength="15" pattern="[A-Za-z0-9._]{2,15}" required />

                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" placeholder="Votre email" required />

                        <label for="subject">Sujet :</label>
                        <input type="text" id="subject" name="subject" placeholder="Objet de votre demande" minlength="2" required />

                        <label for="message">Message :</label>
                        <textarea id="message" name="message" placeholder="" minlength="5" required></textarea>

                        <input class="submit" type="submit" value="Envoyer">
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'src/component/footer.php'; ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>
</html>