<?php
session_name("main");
session_start();
require_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD

// Vérification de la soumission d'un mot-clé 

if (!empty($_POST['mot_cle'])) {
    $motCle = htmlspecialchars($_POST['mot_cle'], ENT_QUOTES);

    // Préparation et exécution de la requête SQL pour rechercher dans les titres et contenus
    $state = $bdd->prepare("SELECT id, title, content, created_at FROM article WHERE title LIKE ? OR content LIKE ? ORDER BY id ");
    $state->execute(['%' . $motCle . '%', '%' . $motCle . '%']);
    $articlesbymotcle = $state->fetchAll();
} else {
    echo "Aucun mot-clé saisi.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/searchStyle.css" />

    <title>Résultats de recherche</title>
</head>

<body>
    <?php include 'src/component/navbar.php'; ?>
    <div class="container">
    <h2>Résultat (s) pour "<?php echo htmlspecialchars($motCle); ?>"</h2>
    <div class="row">
        <?php if (!empty($articlesbymotcle)) {
            foreach ($articlesbymotcle as $articlebymotcle) { ?>
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="article-card">
                        <img src="assets/img/section1background.jpg" class="img-fluid" alt="Image de l'article">
                        <div class="content">
                            <h3><?php echo htmlspecialchars($articlebymotcle['title']); ?></h3>
                            <span class="date">Publiée le <?php echo htmlspecialchars($articlebymotcle['created_at']); ?></span>
                            <a href="article.php?id=<?php echo $articlebymotcle['id']; ?>" class="read-more">Continuer la lecture</a>
                        </div>
                    </div>
                </div>
        <?php }
        } else {
            echo "<p>Aucun article trouvé pour ce mot-clé.</p>";
        } ?>
    </div>
</div>

    <?php include 'src/component/footer.php'; ?>
</body>

</html>


