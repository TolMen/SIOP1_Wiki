<?php
session_name("main");
session_start();
require_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD
include_once 'checkBanned.php'; // Vérification si l'utilisateur est banni
include_once 'src/model/SearchModel/getSearchModel.php';
include_once 'src/model/ArtModel/postArtModel.php';


// Vérification de la soumission d'un mot-clé 

if (!empty($_POST['mot_cle'])) {
    $motCle = htmlspecialchars($_POST['mot_cle'], ENT_QUOTES);
    // Préparation et exécution de la requête SQL pour rechercher dans les titres et contenus
    // $state = $bdd->prepare("SELECT id, title, content, created_at FROM article WHERE title LIKE ? OR content LIKE ? ORDER BY id ");
    // $state->execute(['%' . $motCle . '%', '%' . $motCle . '%']);
    // $articlesbymotcle = $state->fetchAll();
    //     $gethystory = new getHistoriqueModel();
    // $articlesversion = $gethystory->getHistorique($bdd, $article_id);

    $getresearch = new getSearchModel();
    $articlesbymotcle = $getresearch->getRecherche($bdd, $motCle);
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
                </div>
                <input class="recherche" type="submit" value="Rechercher" />
            </form>
        </div>

        <div class="row" >
             <div class="articles-grid">
                <?php if (!empty($articlesbymotcle)) {
                    foreach ($articlesbymotcle as $articlebymotcle) { 
                        $artPostModel = new ArtPostModel();
                        $imageData = $artPostModel->getArticleImage($bdd, $articlebymotcle['id']);
                        $imageUrl = $imageData['url'] ?? 'assets/img/section1background.jpg'; //  Image par défaut
                    
                        ?>
                         <div class="article-card">
                            <div class="image_contenu">
                                <img src="<?= htmlspecialchars($imageUrl) ?>" alt="Image de l'article">
                            </div>
                            <div class="content">
                                <h3><?php echo htmlspecialchars($articlebymotcle['title']); ?></h3>
                                <span class="date">Publié le : 
                                    <?php if(empty($articlebymotcle['updated_at'])) {
                                        echo date("d/m/Y à H:i:s", strtotime($articlebymotcle['created_at']));
                                    } else {
                                        echo date("d/m/Y à H:i:s", strtotime($articlebymotcle['updated_at']));
                                    } ?></span>
                                <div class="article_choix">
                                    <a href="templateArt.php?articleID=<?php echo $articlebymotcle['id']; ?>" class="read-more">
                                        Continuer la lecture
                                    </a>
                                    <?php if (!empty($_SESSION["userID"]) && $_SESSION["userRole"] === "admin") { ?>
                                        <a href="src/control/ArtControl/deleteArt.php?articleID=<?php echo $articlebymotcle['id']; ?>">
                                            <img src="assets/svg/trash.svg" alt="Supprimer l'article">
                                        </a>
                                    <?php   } ?>
                                </div>
                                <a href="historique.php?articleID=<?php echo $articlebymotcle['id']; ?>" class="read-morehistorique">Voir l'historique</a>
                            </div>
                        </div>
                    
                <?php }
                } else {
                    echo "<p>Aucun article trouvé pour ce mot-clé.</p>";
                } ?>
            </div> 

        </div>
    </div>

    <?php include 'src/component/footer.php'; ?>
</body>

</html>