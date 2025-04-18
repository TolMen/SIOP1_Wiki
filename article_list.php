<?php

session_name("main");
session_start();

include_once 'src/control/BDDControl/connectBDD.php'; // $bdd
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
    <!-- Inclusion des balise meta -->
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/listStyle.css" />

    <title>Civilipédia - Gestion des articles</title>
</head>


<body>
<!-- Inclusion de la barre de navigation -->
<?php include_once 'src/component/navbar.php' ?>

<!-- Code -->
<form method="POST" action="article_list.php" class="filer_form">
    <div class="form-item">
        <label>ID :</label>
        <input class="form-control me-2" type="number" min="1" name="id" />
    </div>
    <div class="form-item">
        <label>Mots-clés :</label>
        <input class="form-control me-2" type="text" name="mots_cles" />
    </div>
    <div class="form-item">
        <label>ID auteur :</label>
        <input class="form-control me-2" type="number" min="1" name="user_id" />
    </div>
    <input type="submit" value="Rechercher" />

    <a class="text-danger" href="src/control/ArtControl/resetAllArt.php">Réinitialiser les articles</a>
</form>

<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Titre</th>
        <th scope="col">ID auteur</th>
        <th scope="col">Date de création</th>
        <th scope="col">Date de modification</th>
        <th scope="col">Suppression</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($articles as $article) { ?>
        <tr>
            <th scope="row"><?php echo $article["id"] ?></th>
            <td><a style="color: black; text-decoration: none" href="templateArt.php?articleID=<?php echo $article["id"] ?>"><?php echo $article["title"] ?></a></td>
            <td><?php echo $article["user_id"] ?></td>
            <td><?php echo date("d/m/Y", strtotime($article["created_at"])) ?></td>
            <td><?php echo !empty($article["updated_at"]) ? date("d/m/Y", strtotime($article["updated_at"])) : date("d/m/Y", strtotime($article["created_at"])); ?></td>
            <td><a style="color: red" href="src/control/ArtControl/deleteArt.php?articleID=<?php echo $article["id"] ?>">Supprimer l'article</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<!-- Inclusion du pied de page -->
<?php include 'src/component/footer.php' ?>

<!-- Liens vers les scripts JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
</body>

</html>