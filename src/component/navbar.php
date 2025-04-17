<?php
$current_page = basename($_SERVER['PHP_SELF']); // Récupère uniquement le nom du fichier actuel
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top custom-navbar">
    <div class="container-fluid">
        <span class="navbar-brand"></i> Civilipédia</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link custom-nav-link <?php echo ($current_page == 'home.php') ? 'active text-primary' : ''; ?>" href="home.php">Accueil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link custom-nav-link <?php echo ($current_page == 'contact.php') ? 'active text-primary' : ''; ?>" href="contact.php">Contact</a>
                </li>

                <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link <?php echo ($current_page == 'dashboard.php') ? 'active text-primary' : ''; ?>" href="dashboard.php">Dashboard</a>
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