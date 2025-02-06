<?php
session_name("main");
session_start();
if (empty($_SESSION['userID'])) {
    header('Location: home.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Inclusion des balise meta -->
    <?php include 'src/component/head.php'; ?>

    <title>Création d'article</title>
</head>

<body>

    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php' ?>

    <!-- Section pour publier un article -->
    <section class="container py-5">
        <h2 class="text-center mb-4">Publier un article</h2>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form method="POST" action="src/control/ArtControl/addArt.php" enctype="multipart/form-data" class="bg-light p-4 rounded shadow">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre *</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Entrez le titre de l'article" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Contenu *</label>
                        <textarea id="content" name="content" rows="6" class="form-control" placeholder="Écrivez le contenu ici..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Images *</label>
                        <input type="file" id="images" name="images" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="datePublication" class="form-label">Date de publication *</label>
                        <input type="date" id="createdAt" name="createdAt" class="form-control" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="publishArticle" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Publier l'article
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Fin de section pour publier un article -->

    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <!-- Sripts JavaScript -->
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