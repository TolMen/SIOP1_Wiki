<?php
session_name("main");
session_start();
if (empty($_SESSION['userID'])) {
    header('Location: home.php');
    exit;
}

/* Inclusion des fichiers nécessaires */
require_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD
require_once 'src/model/ArtModel/getArtModel.php'; // Le modèle pour récupérer les articles

// Vérifiez si un ID est passé en paramètre
if (isset($_GET['articleID'])) {
    $articleID = $_GET['articleID'];
    $updateArticleModel = new UpdateArticleModel();

    // Récupérer l'article
    $articleAncien = $updateArticleModel->getArticleId($bdd, $articleID);

    // Vérifiez si l'article existe
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
    <!-- Inclusion des balise meta -->
    <?php include 'src/component/head.php'; ?>

    <title>Modification d'article</title>
</head>

<body>

    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php' ?>

    <!-- Section pour éditer un article -->
    <section class="container my-5">
        <h2 class="text-center mb-4">Modifier l'article</h2>
        <div class="card shadow-lg">
            <div class="card-body">
                <form method="POST" action="src/control/ArtControl/updateArtControl.php?articleID=<?php echo $articleID; ?>">
                    <!-- Titre -->
                    <div class="mb-3">
                        <label class="form-label">Titre</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?php echo $articleAncien['title']; ?>" autocomplete="off" required>
                    </div>
                    <!-- Contenu -->
                    <div class="mb-3">
                        <label class="form-label">Contenu</label>
                        <textarea class="form-control" id="content" name="content" rows="5" autocomplete="off" required><?php echo $articleAncien['content']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Nouvelle image</label>
                        <input type="file" id="images" name="images" class="form-control">
                    </div>
                    <!-- Bouton de validation -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100" name="updateArticle">Valider les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Fin de section pour éditer un article -->

    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <!-- Scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: [
                // Core editing features
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                // Your account includes a free trial of TinyMCE premium features
                // Try the most popular premium features until Feb 14, 2025:
                'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
            setup: function(editor) {
                editor.on('change', function() {
                    tinymce.triggerSave();
                });
            }
        });

        // Ajout d'un event listener pour le formulaire
        document.querySelector("form").addEventListener("submit", function() {
            tinymce.triggerSave();
        });
    </script>
</body>

</html>