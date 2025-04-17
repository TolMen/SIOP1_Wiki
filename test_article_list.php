<?php

session_name("main");
session_start();

include_once 'src/control/BDDControl/connectBDD.php'; // $bdd
include_once 'src/model/ArtModel/getArtModel.php';

$id = !empty($_POST["id"]) ? htmlspecialchars($_POST["id"], ENT_QUOTES) : "%";
$title = !empty($_POST["title"]) ? "%" . htmlspecialchars($_POST["title"] . "%", ENT_QUOTES) : "%";
$content = !empty($_POST["content"]) ? "%" . htmlspecialchars($_POST["content"] . "%", ENT_QUOTES) : "%";
$user_id = !empty($_POST["user_id"]) ? htmlspecialchars($_POST["user_id"], ENT_QUOTES) : "%";

if (!empty($_SESSION["userID"]) && $_SESSION["userRole"] == "admin") {
    $getArticleModel = new GetArtModel();
    $articles = $getArticleModel->getFiltredArticles($bdd, $id, $title, $content, $user_id);
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
    <link rel="stylesheet" href="css/test_listStyle.css" />

        <title>Civilipédia - Gestion des articles</title>
    </head>


<body>
    <!-- Inclusion de la barre de navigation -->
    <?php include_once 'src/component/navbar.php' ?>

    <!-- Code -->
    <div class='userList row'>
        <div class="queryUsers col-10">
            <form method="POST" action="article_list.php">
                <label>ID :</label>
                <input class="inputID" type="number" min="0" name="id" />

                <label>Titre :</label>
                <input class="inputUsername" type="text" name="title" />

                <label>Mot clé :</label>
                <input class="inputUsername" type="text" name="content" />

                <label for="userID">ID auteur :</label>
                <input class="inputID" type="number" min="0" name="user_id" />

                <input class="buttonSubmit" type="submit" value="Rechercher" />

                <a class="text-danger" href="src/control/ArtControl/resetAllArt.php">Réinitialiser les articles</a>
            </form>
        </div>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Titre</th>
                <th scope="col">ID auteur</th>
                <th scope="col">Date de création</th>
                <th scope="col">Date de modification</th>
                <th scope="col">Supprimer l'article</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($articles as $article) { ?>
                <tr>
                    <th scope="row"><?php echo $article["id"] ?></th>
                    <td><?php echo $article["title"] ?></td>
                    <td><?php echo $article["user_id"] ?></td>
                    <td><?php echo date("d/m/Y", strtotime($article["created_at"])) ?></td>
                    <td><?php echo !empty($article["updated_at"]) ? date("d/m/Y", strtotime($article["updated_at"])) : date("d/m/Y", strtotime($article["created_at"])); ?></td>
                    <td><a href="templateArt.php?articleID=<?php echo $article["id"] ?>">Lien de l'article</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>

    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>