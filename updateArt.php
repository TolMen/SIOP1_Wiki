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
include_once 'checkBanned.php'; // Vérification si l'utilisateur est banni

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
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

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
                <form method="POST" enctype="multipart/form-data" action="src/control/ArtControl/updateArtControl.php?articleID=<?php echo $articleID; ?>">
                    <!-- Titre -->
                    <div class="mb-3">
                        <label class="form-label">Titre</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?php echo $articleAncien['title']; ?>" autocomplete="off" required>
                    </div>
                    <!-- Contenu -->
                    <div class="mb-3">
                        <label for="editor" class="form-label">Contenu *</label>
                        <div id="editor" style="height: 100px;" required><?php echo $articleAncien['content']; ?></div>
                        <input type="hidden" id="hidden-content" name="content">
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Nouvelle image (Non obligatoire)</label>
                        <input type="file" id="images" name="images" class="form-control">
                    </div>
                    <!-- Bouton de validation -->
                    <div class="text-left">
                        <button type="submit" class="btn btn-primary w-30" name="updateArticle">Valider les modifications</button>
                        <button class="btn btn-danger w-15" onclick="history.back()">Annuler</button>
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