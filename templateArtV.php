<?php
session_name("main");
session_start();
include_once 'src/control/BDDControl/connectBDD.php';
include_once 'src/control/BDDControl/checkBanned.php';

// Récupérer l'ID de la version depuis l'URL
$articleVID = intval($_GET['articleVID']);

// Vérifier que l'ID est valide
if ($articleVID <= 0) {
    echo "ID de version invalide.";
    exit;
}


// Requête pour récupérer la version spécifique de l'article
$state = $bdd->prepare("SELECT article_version.*, user.username AS creator_name, 
                        (SELECT username FROM user
                        INNER JOIN article ON article.user_id = user.id 
                        WHERE user.id = article.firstAuthor 
                        AND article.id = article_version.article_id) AS first_author_name 
                        FROM article_version 
                        INNER JOIN user ON user.id = article_version.user_id 
                        WHERE article_version.id = ?");
$state->execute(array($articleVID));
$articleversion = $state->fetch();

// Vérifier si la version existe
if (!$articleversion) {
    echo "Version introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/templateArtVStyle.css" />
    <title>
        Historique de l'article
        <?php
        $artVID = intval($_GET['articleVID']);
        echo $artVID;
        ?>
    </title>
</head>

<body>

    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php'; ?>

    <!-- Section principale -->
    <div class="container mt-5">

        <h2 class="text-center mb-4 affichage">Version complète de l'article</h2>

        <div class="card shadow-sm p-4 version_content">
            <h3 class="card-title titre"><?php echo htmlspecialchars($articleversion['title']); ?></h3>

            <div class=" justify-content-between align-items-center">
                <p><strong>✏️ Modifié par:</strong> <?php echo htmlspecialchars($articleversion['creator_name']); ?></p>
                <p><strong> 📝 Créé par  </strong> <?= htmlspecialchars($articleversion['first_author_name']); ?> <strong> le: 📅 </strong> <?php echo date("d/m/Y H:i", strtotime($articleversion['created_at'])); ?></p>
            </div>

            <div class="content mb-4">
                <p><strong>Contenu de l'article</strong></p>
                <div class="border p-3 rounded version_contenu">
                    <?php echo nl2br(htmlspecialchars($articleversion['content'])); ?>
                </div>
            </div>

        </div>

    </div>

    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php'; ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>