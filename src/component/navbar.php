<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <span class="navbar-brand"></i> Civilipédia</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="home.php" aria-current="page">Accueil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="home.php#list_art" aria-current="page">Liste des articles</a>
                </li>

                <?php
                if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'admin') {
                    echo '
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                    ';
                }

                if (!empty($_SESSION['userID'])) {
                    echo ' 
                        <li class="nav-item">
                            <a class="nav-link" href="createArt.php">Publier un article</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-danger" href="src/control/UserControl/logout.php" title="Déconnexion">Déconnexion</a>
                        </li>
                    ';
                } else {
                    echo '
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Inscription</a>
                        </li>
                    ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>