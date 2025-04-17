<?php
$current_page = basename($_SERVER['PHP_SELF']); // Récupère uniquement le nom du fichier actuel
?>

<nav class="navbar navbar-expand-xl navbar-light bg-light fixed-top custom-navbar">
    <div class="container-fluid">
        <a href="home.php">
            <span class="navbar-brand">Civilipédia</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <form class="d-flex position-relative" role="search">
                <input class="form-control me-2" type="search" placeholder="Rechercher un article..." aria-label="Search" id="searchInput" autocomplete="off">
                <ul id="searchResults" class="list-group position-absolute w-100" style="z-index: 1000;"></ul>
            </form>

            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link custom-nav-link <?php echo ($current_page == 'home.php') ? 'active text-primary' : ''; ?>" href="home.php">Accueil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link custom-nav-link <?php echo ($current_page == 'contact.php') ? 'active text-primary' : ''; ?>" href="contact.php">Contact</a>
                </li>

                <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'admin'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link custom-nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Administration</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="article_list.php">Gestion des articles</a></li>
                            <li><a class="dropdown-item" href="user_list.php">Gestion des utilisateurs</a></li>
                            <li><a class="dropdown-item" href="messagerie.php">Messagerie</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="src/control/ArtControl/resetAllArt.php">Réinitialiser les articles</a></li>
                            <li><a class="dropdown-item text-danger" href="src/control/UserControl/resetAllUser.php">Réinitialiser les utilisateurs</a></li>
                        </ul>
                    </li>

                <?php endif; ?>

                <?php if (!empty($_SESSION['userID'])): ?>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link <?php echo ($current_page == 'createArt.php') ? 'active text-primary' : ''; ?>" href="createArt.php">Publier un article</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="src/control/UserControl/logout.php" title="Déconnexion">Déconnexion</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link <?php echo ($current_page == 'login.php') ? 'active text-primary' : ''; ?>" href="login.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link <?php echo ($current_page == 'register.php') ? 'active text-primary' : ''; ?>" href="register.php">Inscription</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script src="js/liveSearch.js"></script>