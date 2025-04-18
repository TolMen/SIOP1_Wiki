<?php

session_name("main");
session_start();

include_once 'checkBanned.php';

$messages = [
    "loginExist" => "Ce pseudo existe déjà !",
    "idemPassword" => "Les mots de passe ne correspondent pas !"
];

$errorKey = isset($_GET) ? array_key_first($_GET) : null;
$errorMessage = isset($messages[$errorKey]) ? htmlspecialchars($messages[$errorKey], ENT_QUOTES) : null;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Inclusion des balise meta -->
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/styleAccount/styleIdemAccountForm.css" />
    <link rel="stylesheet" href="css/styleAccount/styleRegistForm.css">
    <link rel="stylesheet" href="css/stylePopUp/stylePopUp.css">
    <title>Civilipédia - Inscription</title>
</head>

<body>
    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php' ?>


    <div class="main-container">
        <!-- Form box -->
        <div class="box">
            <span class="borderLine"></span>
            <!-- Form -->
            <form method="POST" action="src/control/UserControl/registUser.php">
                <h2>Inscription</h2>
                <!-- Input fields -->
                <div class="boxIdentity">
                    <div class="inputBox inputBoxOther">
                        <input type="text" name="username" maxlength="26" pattern="[a-zA-Z0-9._]{3,26}" title="Seules les lettres, chiffres, '.' et '_' sont autorisés (entre 3 et 26 caractères)" autocomplete="off" required>
                        <span>Pseudo</span>
                        <i></i>
                    </div>
                </div>
                <div class="inputBox inputBoxOther">
                    <input type="password" name="password" pattern="[A-Za-zÀ-ÿ0-9.]+" maxlength="15" title="Le mot de passe doit contenir des lettres, des chiffres et uniquement le symboles POINT" autocomplete="off" required>
                    <span>Mot de passe</span>
                    <i></i>
                </div>
                <div class="inputBox inputBoxOther">
                    <input type="password" name="confirmPassword" pattern="[A-Za-zÀ-ÿ0-9.]+" maxlength="15" autocomplete="off" required>
                    <span>Confirmer votre mot de passe</span>
                    <i></i>
                </div>

                <!-- End of Input fields -->
                <div class="links">
                    <a href="login.php">Connexion</a>
                </div>
                <input type="submit" name="inscription" value="S'inscrire">
            </form>
            <!-- End of Form -->
        </div>
        <!-- End of Form box -->
    </div>

    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <!-- Popup error -->
    <?php if (!empty($errorMessage)) { ?>
        <div id="popup" class="popup show">
            <div class="popup-content">
                <p><?php echo $errorMessage; ?></p>
                <a href="register.php" id="closePopup">Fermer</a>
            </div>
        </div>
    <?php } ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="js/popupScript.js"></script>
</body>

</html>