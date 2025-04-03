<?php
session_name("main");
session_start();
include_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD
include_once 'checkBanned.php'; // Vérification si l'utilisateur est banni
include_once 'src/model/ArtModel/postArtModel.php';

// Préparation la requête pour récupérer tous les articles
$artPostModel = new ArtPostModel();
$articles = $artPostModel->getAllArt($bdd);

// Vérification que des articles sont récupérés
if (empty($articles)) {
    echo "Aucun article trouvé.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Inclusion des balises meta -->
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/homeStyle.css" />

    <title>Civilipédia</title>
</head>

<body>

    <!-- Inclusion de la barre de navigation -->
    <?php include 'src/component/navbar.php' ?>

    <div class="body-content">

        <section id="presentation_section">
            <div class="container phrase_accroche ">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h1 class="">BIENVENUE</h1>
                        <h5 class="">SUR</h5>
                        <h2 class="">CIVILIPEDIA</h2>
                    </div>
                </div>
                <p class="lead text-center">Votre source d'informations sur les civilisations du monde.</p>
            </div>
        </section>

        <section class="description ">
            <div class="description-content">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 infos">
                            <h2>Les CIVILISATIONS !</h2>
                            <p>
                                Les civilisations, formées par des sociétés organisées,
                                se distinguent par leurs avancées culturelles, politiques
                                et économiques. Chaque civilisation laisse un héritage unique, qu’il s’agisse
                                de monuments,de découvertes scientifiques ou de traditions,
                                influençant ainsi les générations futures et contribuant à façonner notre monde moderne.
                            </p>

                        </div>
                        <div class="col-md-6 img-description-content ">
                            <img
                                src="assets/img/civilisation.png"
                                alt="Image"
                                class="img-size" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="line-content">
                <div class="line"></div>
                <span>Les articles</span>
                <div class="line"></div>
            </div>
        </section>

        <section id="search">

            <!-- Recherche par mot-cle -->
            <div id="search_content">
                <form class="formulaire" method="POST" action="search.php">
                    <div class="content_recherche">
                        <img src="assets/svg/search.svg" alt="">
                        <input type="search" name="mot_cle" id="" placeholder="Entrez un mot-clé" required>
                    </div>
                    <input class="recherche" type="submit" value="Rechercher" />
                </form>
            </div>

            <div id="list_art">
                <div class="articles-grid">
                    <?php
                    foreach ($articles as $article) {
                        $artPostModel = new ArtPostModel();
                        $imageData = $artPostModel->getArticleImage($bdd, $article['id']);
                        $imageUrl = $imageData['url'] ?? 'assets/img/civilisation.png'; //  Image par défaut
                    ?>
                        <div class="article-card">
                            <div class="image_contenu">
                                <img src="<?= htmlspecialchars($imageUrl) ?>" alt="Image de l'article">
                            </div>
                            <div class="content">
                                <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                                <span class="date">En date :
                                    <?php if (empty($article['updated_at'])) {
                                        echo date("d/m/Y à H:i", strtotime($article['created_at']));
                                    } else {
                                        echo date("d/m/Y à H:i", strtotime($article['updated_at']));
                                    } ?></span>
                                <div class="article_choix">
                                    <a href="templateArt.php?articleID=<?php echo $article['id']; ?>" class="read-more">
                                        Continuer la lecture
                                    </a>
                                    <?php if (!empty($_SESSION["userID"]) && $_SESSION["userRole"] === "admin") { ?>
                                        <a href="src/control/ArtControl/deleteArt.php?articleID=<?php echo $article['id']; ?>">
                                            <i class="fa-solid fa-trash" title="Supprimer l'article" style="color: red;"></i>
                                        </a>
                                    <?php   } ?>
                                </div>
                                <a href="historique.php?articleID=<?php echo $article['id']; ?>" class="read-morehistorique">Voir l'historique</a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>


        </section>

        <section class="civilization-section">
            <div class="container">
                <h2>🌍 Découvrez les Civilisations du Monde 🏛️</h2>
                <p class="quote">
                    "Une civilisation se mesure à ce qu'elle laisse à ses descendants."
                </p>
                <a href="contact.php" class="explore-btn">Contactez nous</a>
            </div>
        </section>


    </div>
    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>