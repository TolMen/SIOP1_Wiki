<?php
session_name("main");
session_start();

if (empty($_SESSION['userID'])) {
    header('Location: home.php');
    exit;
}

include_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD
include_once 'checkBanned.php'; // Vérification si l'utilisateur est banni

$messages = [
    "compressionFail" => "Erreur lors de la compression de l'image",
    "extentionFail" => "Erreur lors de l'upload de l'image",
    "uploadFail" => "Erreur lors de l'upload de l'image",
];

$errorKey = isset($_GET) ? array_key_first($_GET) : null;
$errorMessage = isset($messages[$errorKey]) ? htmlspecialchars($messages[$errorKey], ENT_QUOTES) : null;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Inclusion des balise meta -->
    <?php include 'src/component/head.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/styleArticle/styleCUArt.css" />
    <link rel="stylesheet" href="css/stylePopUp/stylePopUp.css">
    <title>Création d'article</title>
</head>

<body>
    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php'; ?>

    <div class="main-container">
        <div class="box">
            <form id="formArt" method="POST" action="src/control/ArtControl/addArt.php" enctype="multipart/form-data">
                <h2>Publier un article</h2>

                <div class="boxIdentity">
                    <div class="inputBox inputBoxIdentity">
                        <input type="text" id="title" name="title" required />
                        <span>Titre *</span>
                        <i></i>
                    </div>
                </div>

                <div class="boxContent">
                    <span class="content">Contenu *</span>
                    <div class="editor">
                        <div class="editorQuill" id="editor" required></div>
                        <input type="hidden" id="hidden-content" name="content">
                    </div>
                </div>

                <div class="boxOther">
                    <div class="inputBox inputBoxOther full-width">
                        <input type="file" id="images" name="images" required />
                        <span>Image *</span>
                        <i></i>
                    </div>

                    <div class="inputBox inputBoxOther full-width">
                        <input type="date" id="createdAt" name="createdAt" value="<?php echo date('Y-m-d'); ?>" required />
                        <span>Date de publication *</span>
                        <i></i>
                    </div>
                </div>

                <div class="link">
                    <input type="submit" name="publishArticle" value="Publier l'article">
                    <a href="home.php" class="cancel-link">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php'; ?>

    <!-- Popup error -->
    <?php if (!empty($errorMessage)) { ?>
        <div id="popup" class="popup show">
            <div class="popup-content">
                <p><?php echo $errorMessage; ?></p>
                <a href="createArt.php" id="closePopup">Fermer</a>
            </div>
        </div>
    <?php } ?>

    <!-- Scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        var form = document.querySelector('#formArt');
        form.onsubmit = function() {
            var hiddenContent = document.querySelector('input[name=content]');
            hiddenContent.value = quill.root.innerHTML; // Récupère le contenu en HTML
        };
    </script>
    <script src="js/popupScript.js"></script>
</body>

</html>