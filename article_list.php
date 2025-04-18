<?php
session_name("main");
session_start();

include_once 'src/control/BDDControl/connectBDD.php';
include_once 'src/model/ArtModel/getArtModel.php';

$id = !empty($_POST["id"]) ? htmlspecialchars($_POST["id"], ENT_QUOTES) : "%";
$mots_cles = !empty($_POST["mots_cles"]) ? "%" . htmlspecialchars($_POST["mots_cles"] . "%", ENT_QUOTES) : "%";
$user_id = !empty($_POST["user_id"]) ? htmlspecialchars($_POST["user_id"], ENT_QUOTES) : "%";

if (!empty($_SESSION["userID"]) && $_SESSION["userRole"] == "admin") {
    $getArticleModel = new GetArtModel();
    $articles = $getArticleModel->getFiltredArticles($bdd, $id, $mots_cles, $user_id);
} else {
    header("Location: javascript://history.go(-1)");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/styleAdmin/artList.css" />
    <link rel="stylesheet" href="css/stylePopUp/stylePopUp.css">
    <title>Civilipédia - Articles</title>
</head>

<body>
    <?php include_once 'src/component/navbar.php'; ?>

    <header class="header">
        <div class="text">
            <h1>Articles</h1>
            <p>Liste des articles publiés.</p>
        </div>
    </header>

    <main class="main-container">
        <div class="container">
            <div class="filter-wrapper">
                <form method="POST" action="article_list.php" class="filter-form">
                    <div class="filter-fields">
                        <div class="inputBox inputBoxFilter">
                            <input type="text" name="id" />
                            <span>ID</span>
                            <i></i>
                        </div>

                        <div class="inputBox inputBoxFilter">
                            <input type="text" name="mots_cles" />
                            <span>Mots-clés</span>
                            <i></i>
                        </div>

                        <div class="inputBox inputBoxFilter">
                            <input type="text" name="user_id" />
                            <span>Auteur</span>
                            <i></i>
                        </div>

                        <div class="submit-container">
                            <input type="submit" value="Rechercher" class="btn btn-primary" />
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-container">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Création</th>
                            <th>Dernière modif.</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article) { ?>
                            <tr>
                                <td><?= $article['id'] ?></td>
                                <td><?= htmlspecialchars($article['title']) ?></td>
                                <td><?= $article['user_id'] ?></td>
                                <td><?= date("d/m/Y", strtotime($article['created_at'])) ?></td>
                                <td><?= !empty($article["updated_at"]) ? date("d/m/Y", strtotime($article["updated_at"])) : "-" ?></td>
                                <td>
                                    <a href="templateArt.php?articleID=<?= $article['id'] ?>" class="btn btn-sm btn-outline-dark">Voir</a>
                                    <a href="src/control/ArtControl/deleteArt.php?articleID=<?= $article['id'] ?>" class="btn btn-sm btn-outline-danger">Supprimer</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php include 'src/component/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>