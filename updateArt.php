<?php
session_name("main");
session_start();

if (empty($_SESSION['userID'])) {
    header('Location: home.php');
    exit;
}

include_once 'src/control/BDDControl/connectBDD.php';
include_once 'src/model/ArtModel/getArtModel.php';
include_once 'checkBanned.php';

if (isset($_GET['articleID'])) {
    $articleID = $_GET['articleID'];
    $updateArticleModel = new GetArtModel();
    $articleAncien = $updateArticleModel->getArticleId($bdd, $articleID);

    if (!$articleAncien) {
        die("Erreur : Article introuvable.");
    }
} else {
    die("Erreur : Aucun ID d'article spécifié.");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'src/component/head.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/styleArticle/styleCUArt.css" />
    <title>Modification d'article</title>
</head>

<body>
    <?php include 'src/component/navbar.php'; ?>

    <div class="main-container">
        <div class="box">
            <form id="formArt" method="POST" action="src/control/ArtControl/updateArtControl.php?articleID=<?php echo $articleID; ?>" enctype="multipart/form-data">
                <h2>Modifier l'article</h2>

                <div class="boxIdentity">
                    <div class="inputBox inputBoxIdentity">
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($articleAncien['title']); ?>" required />
                        <span>Titre *</span>
                        <i></i>
                    </div>
                </div>

                <div class="boxContent">
                    <span class="content">Contenu *</span>
                    <div class="editor">
                        <div class="editorQuill" id="editor"><?php echo $articleAncien['content']; ?></div>
                        <input type="hidden" id="hidden-content" name="content">
                    </div>
                </div>

                <div class="boxOther">
                    <div class="inputBox inputBoxOther full-width">
                        <input type="file" id="images" name="images" />
                        <span>Nouvelle image (facultatif)</span>
                        <i></i>
                    </div>
                </div>

                <div class="link">
                    <input type="submit" name="updateArticle" value="Valider">
                    <a href="javascript:history.back()" class="cancel-link">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <?php include 'src/component/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        var form = document.querySelector('#formArt');
        form.onsubmit = function() {
            var hiddenContent = document.querySelector('input[name=content]');
            hiddenContent.value = quill.root.innerHTML;
        };
    </script>
</body>

</html>