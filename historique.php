<?php
session_name("main");
session_start();

include_once 'src/control/BDDControl/connectBDD.php';
include_once 'src/model/HistoriqueModel/getHistoriqueModel.php';
include_once 'src/control/ArtControl/postArt.php'; // On récupère l'article courant

$article_id = htmlspecialchars($_GET["articleID"], ENT_QUOTES);
$gethystory = new getHistoriqueModel();
$articlesversion = $gethystory->getHistorique($bdd, $article_id);

$latestUpdateDate = null;
if (!empty($articlesversion)) {
    usort($articlesversion, function ($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    $latestUpdateDate = $articlesversion[0]['created_at'];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/styleArticle/artStyle.css" />
    <title>Historique : <?= htmlspecialchars($article['title']); ?></title>
</head>

<body>
    <?php include 'src/component/navbar.php'; ?>

    <section class="main-container">
        <div class="article-wrapper container">
            <!-- Titre -->
            <div class="row">
                <div class="col-12">
                    <div class="article-header text-center">
                        <h1 class="article-title"><?= htmlspecialchars($article['title']); ?></h1>
                    </div>
                </div>
            </div>

            <!-- Historique + image -->
            <div class="row">
                <!-- Liste des versions -->
                <div class="col-lg-8 order-last order-lg-first">
                    <div class="article-content">
                        <h3 class="mb-3">🕘 Historique des versions</h3>

                        <?php if ($articlesversion): ?>
                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                <i class="bi bi-clock-history me-2"></i>
                                <div>
                                    Cet article possède <strong><?= count($articlesversion); ?></strong> version(s),
                                    dernière mise à jour le
                                    <strong><?= $latestUpdateDate ? date("d/m/Y à H:i", strtotime($latestUpdateDate)) : 'N/A'; ?></strong>.
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Titre</th>
                                            <th>Contenu</th>
                                            <th>Créateur</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($articlesversion as $version): ?>
                                            <tr>
                                                <td class="text-center"><?= $i++; ?></td>
                                                <td class="text-center"><?= htmlspecialchars($version['title']); ?></td>
                                                <td><?= substr(strip_tags($version['content']), 0, 100) . '...'; ?></td>
                                                <td class="text-center"><?= htmlspecialchars($version['creator_name']); ?></td>
                                                <td class="text-center">
                                                    <a href="templateArtV.php?articleVID=<?= $version['id']; ?>" class="btn btn-sm btn-outline-dark">
                                                        Voir
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">Aucun historique trouvé pour cet article...</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Image + meta -->
                <div class="col-lg-4 order-first order-lg-last">
                    <div class="article-image-desktop sticky-top z-0">
                        <div class="link mb-3">
                            <a href="templateArt.php?articleID=<?= $article['id']; ?>" class="btn btn-outline-dark btn-sm">Lire</a>
                            <a href="#" class="btn btn-outline-dark btn-sm active">Historique</a>
                            <?php if (isset($_SESSION['userID'])) { ?>
                                <a href="updateArt.php?articleID=<?= $article['id']; ?>" class="btn btn-outline-dark btn-sm">Modifier</a>
                            <?php } ?>
                        </div>
                        <div class="image-wrapper-view">
                            <img src="<?= htmlspecialchars($imageUrl); ?>" alt="Image de l'article" class="img-fluid rounded shadow article-image-view">
                        </div>
                        <div class="article-meta mt-3">
                            <p>✏️ Dernière modification par : <strong><?= htmlspecialchars($userArticles['username'] ?? 'Aucune'); ?></strong></p>
                            <p>📅 Le : <strong><?= date("d/m/Y à H:i", strtotime($dateToShow)); ?></strong></p>
                            <p>📝 Auteur d’origine : <strong><?= htmlspecialchars($userFirstArticles['username']); ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'src/component/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>