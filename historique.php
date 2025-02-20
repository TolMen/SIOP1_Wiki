<?php
session_name("main");
session_start();
require_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD

$article_id = htmlspecialchars($_GET["articleID"], ENT_QUOTES);

$state = $bdd->prepare("SELECT * FROM article_version WHERE article_id = ?");
$state->execute(array($article_id));
$articlesversion = $state->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/searchStyle.css" />
    <title>Historique des versions de l'article</title>
</head>

<body>
    <?php include 'src/component/navbar.php'; ?>

    <div class="container mt-4">
        <h2>Historique des versions </h2>

        <?php if ($articlesversion): ?>
            <table class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Version_ID</th>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th>Date de création</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articlesversion as $article): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($article['article_id']); ?></td>
                            <td><?php echo htmlspecialchars($article['title']); ?></td>
                            <td><?php echo substr(htmlspecialchars($article['content']), 0, 100) . '...'; ?></td>
                            <td><?php echo htmlspecialchars($article['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning">
                Aucun article trouvé.
            </div>
        <?php endif; ?>
    </div>
    <?php include 'src/component/footer.php'; ?>
</body>

</html>