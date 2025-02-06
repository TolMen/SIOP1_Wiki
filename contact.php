<?php
session_name("main");
session_start();
require_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/contact.css" />

    <title>Contact</title>
</head>

<body>
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
            <div class="row col-sm-4 col-md-6 col-lg-4  ">

                <div>
                    <form action="form_success.php" method="post">
                        <label for="name">Nom :</label>
                        <input type="text" id="name" name="name" placeholder="Votre nom" required />

                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" placeholder="Votre email" required />

                        <label for="subject">Sujet :</label>
                        <input type="text" id="subject" name="subject" placeholder="Objet de votre demande" required />

                        <label for="message">Message :</label>
                        <textarea class="mb-4" id="message" name="message" placeholder="" required> </textarea>

                        <input class="submit" type="submit" value="Envoyer">
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'src/component/footer.php'; ?>
</body>

</html>