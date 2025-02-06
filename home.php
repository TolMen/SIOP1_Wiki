<?php
session_name("main");
session_start();
require_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD

// Préparation la requête pour récupérer tous les articles
$state = $bdd->prepare("SELECT id, title, content, createdAt FROM articles ORDER BY id DESC");
$state->execute();
$articles = $state->fetchAll();

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
        <section id="presentation_section" >
            <div class="container phrase_accroche">
                <div class="row">
                    <h1>BIENVENUE </h1>
                    <h5>SUR</h5>
                    <h2>CIVILIPEDIA</h2>
                </div>

                <p>Votre source d'informations sur les civilisations du monde.</p>
            </div>
        </section>

        <section class="description ">
            <div class="description-content">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 infos">
                            <h2>Les CIVILISATIONS!</h2>
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
                                src="assets/img/civilisation.jpg"
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
                    ?>
                        <div class="article-card">
                            <img src="assets/img/section1background.jpg" alt="Image de l'article">
                            <div class="content">
                                <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                                <span class="date">Publiée le <?php echo htmlspecialchars($article['createdAt']); ?></span>
                                <a href="templateArt.php?articleID=<?php echo $article['id']; ?>" class="read-more">Continuer la lecture</a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>


        </section>


    </div>
    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <!-- Liens vers les scripts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>