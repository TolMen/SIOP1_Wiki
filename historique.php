<?php
session_name("main");
session_start();
include_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD
include_once 'src/model/HistoriqueModel/getHistoriqueModel.php';

$article_id = htmlspecialchars($_GET["articleID"], ENT_QUOTES);

$gethystory = new getHistoriqueModel();
$articlesversion = $gethystory->getHistorique($bdd, $article_id);


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
        <button class="btn btn-secondary w-15" onclick="history.back()">Retour</button>
        <h2>Historique des versions </h2>

        <?php if ($articlesversion): ?>
            <table class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Numero de version</th>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th>Date de création</th>
                        <th>Créateur</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                    $version_number = 1;
                    foreach ($articlesversion as $article): ?>
                        <tr>
                            <td><?php echo "Version " . $version_number++; ?></td>
                            <td><?php echo htmlspecialchars($article['title']); ?></td>
                            <td><?php echo substr(nl2br($article['content']), 0, 100) . '...'; ?>
                                <a href="templateArtV.php?articleVID=<?php echo $article['id']; ?>" class="read-more">Voir plus</a>
                            </td>
                            <td><?php echo "Le " . date("d/m/Y", strtotime($article['created_at'])) . " à " . date("H:i", strtotime($article['created_at'])); ?></td>
                            <td><?php echo htmlspecialchars($article['creator_name']); ?></td>

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