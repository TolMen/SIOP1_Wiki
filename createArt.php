<?php
session_name("main");
session_start();
if (empty($_SESSION['userID'])) {
    header('Location: home.php');
    exit;
}
include_once 'src/control/BDDControl/connectBDD.php';
include_once 'checkBanned.php';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Inclusion des balise meta -->
    <?php include 'src/component/head.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

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
                        <label for="editor" class="form-label">Contenu *</label>
                        <div id="editor" style="height: 100px;" placeholder="Écrivez le contenu ici..." required></div>
                        <input type="hidden" id="hidden-content" name="content">
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Images *</label>
                        <input type="file" id="images" name="images" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="datePublication" class="form-label">Date de publication *</label>
                        <input type="date" id="createdAt" name="createdAt" value="<?php echo date('Y-m-d'); ?>" class=" form-control" required>
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
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        var form = document.querySelector('form');
        form.onsubmit = function() {
            var hiddenContent = document.querySelector('input[name=content]');
            hiddenContent.value = quill.root.innerHTML; // Récupère le contenu en HTML
        };
    </script>
</body>

</html>