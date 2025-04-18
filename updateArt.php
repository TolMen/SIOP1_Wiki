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

    $imageUrl = !empty($articleAncien['url']) ? $articleAncien['url'] : 'assets/img/imgDefault.jpg';
} else {
    die("Erreur : Aucun ID d'article spécifié.");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/styleArticle/artStyle.css" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <title>Modification : <?= htmlspecialchars($articleAncien['title']); ?></title>
</head>

<body class="editing-mode">
    <?php include 'src/component/navbar.php'; ?>

    <section class="main-container">
        <div class="article-wrapper container">
            <form id="formArt" method="POST" action="src/control/ArtControl/updateArtControl.php?articleID=<?= $articleID ?>" enctype="multipart/form-data">
                <!-- Titre -->
                <div class="row">
                    <div class="col-12">
                        <div class="article-header text-start">
                            <input type="text" id="title" name="title" value="<?= htmlspecialchars($articleAncien['title']); ?>" class="form-control form-control-art form-control-lg fw-bold" required />
                        </div>
                    </div>
                </div>

                <!-- Contenu + image -->
                <div class="row">
                    <!-- Contenu -->
                    <div class="col-lg-8 order-last order-lg-first">
                        <div class="article-content">
                            <div class="editor">
                                <div class="editorQuill" id="editor"><?= $articleAncien['content']; ?></div>
                                <input type="hidden" id="hidden-content" name="content">
                            </div>
                            <div class="mt-4 text-end">
                                <input type="submit" name="updateArticle" value="Valider" class="btn btn-outline-dark btn-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Image + infos -->
                    <div class="col-lg-4 order-first order-lg-last">
                        <div class="article-image-desktop sticky-top z-0">
                            <div class="link mb-3">
                                <a href="templateArt.php?articleID=<?= $articleID; ?>" class="btn btn-outline-dark btn-sm">Lire</a>
                                <a href="historique.php?articleID=<?= $articleID; ?>" class="btn btn-outline-dark btn-sm">Historique</a>
                                <a href="#" class="btn btn-outline-dark btn-sm active">Modifier</a>
                            </div>
                            <div class="position-relative mb-3 image-container">
                                <div class="image-wrapper-edit">
                                    <img src="<?= htmlspecialchars($imageUrl) ?>" alt="Image de l'article" class="img-fluid rounded shadow editable-image" id="preview-img">
                                    <label for="imageUpload" class="edit-icon">
                                        <i class="fas fa-pencil-alt"></i>
                                    </label>
                                </div>
                                <input type="file" id="imageUpload" name="image" accept="image/*" class="d-none" onchange="previewImage(this)">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php include 'src/component/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        document.querySelector('#formArt').onsubmit = function() {
            document.querySelector('#hidden-content').value = quill.root.innerHTML;
        };

        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>