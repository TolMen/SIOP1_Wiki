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
    $getArcticleModel = new GetArtModel();
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
    <link rel="stylesheet" href="css/listStyle.css" />

    <title>Wiki - Liste des articles</title>
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
            </form>
        </div>

        <div class="UserCase active col-8">
            <div class="col-1">ID</div>
            <div class="col-7">Titre</div>
            <div class="col-2">ID auteur</div>
            <div class="col-2">Informations</div>
        </div>

        <div class="col-1"></div>

        <div class="UserCase active col-1">Suppression</div>

        <?php
        foreach ($articles as $article) { ?>
            <div class="userCase col-8">
                <!-- ID -->
                <div class="col-1"><?php echo $article["id"] ?></div>
                <!-- title -->
                <div class="col-7"><?php echo $article["title"] ?></div>
                <!-- user_id -->
                <div class="col-2"><?php echo $article["user_id"] ?></div>
                <!-- Informations -->
                <div class="col-2">&nbsp;&nbsp;Voir plus<img src="assets/img/eye_popup.png" alt="+" data-bs-toggle="modal" data-bs-target="#article<?php echo $article["id"]; ?>" style="cursor: pointer; width: 15px;"></div>
                <div class="modal fade" id="article<?php echo $article["id"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!-- Titre -->
                                <h5 class="modal-title" id="exampleModalLabel">Informations complémentaires</h5>
                                <button
                                    type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>

                            <div class="modal-body">
                                <!-- Intérieur -->
                                Créer le : <?php echo date("d/m/Y", strtotime($article["created_at"])) ?>
                                <br>
                                Mis à jour le :
                                <?php echo !empty($article["updated_at"]) ? date("d/m/Y", strtotime($article["updated_at"])) : date("d/m/Y", strtotime($article["created_at"])); ?>
                                <br>
                                <a href="templateArt.php?articleID=<?php echo $article["id"] ?>">Lien de l'article</a>
                                <br>
                            </div>
                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>
                <!-- Séparation -->
            </div>
            <div class="col-1"></div>

            <!-- Code pour supprimer un article -->
            <div class="userCase col-1">
                <div>
                    <img src="assets/svg/trash.svg" alt="+" data-bs-toggle="modal" data-bs-target="#delete<?php echo $article["id"]; ?>" style="cursor: pointer; width: 40px;">
                </div>
                <div class="modal fade" id="delete<?php echo $article["id"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!-- Titre -->
                                <h5 class="modal-title" id="exampleModalLabel">Supprimer l'article</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Intérieur -->
                                <h5>Voulez-vous supprimer l'article<br>"<?php echo $article["title"] ?>" ?</h5>
                                <br>
                                <a href="src/control/ArtControl/deleteArt.php?articleID=<?php echo $article["id"] ?>">
                                    <button class="buttonSubmit">Supprimer</button>
                                </a>
                            </div>
                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>