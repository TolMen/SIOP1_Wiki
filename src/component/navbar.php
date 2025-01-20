<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <span class="navbar-brand"></i> Wiki - ###</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="home.php" aria-current="page">Accueil</a>
                </li>

                <!-- Mettre une condition par rapport au role ADMIN -->
                <li class="nav-item">
                    <a class="nav-link" href="user_list.php">Utilisateurs</a>
                </li>

                <!-- Mettre une condition par rapport au role -->
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Inscription</a>
                </li>
                <!-- Sinon -->
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php" title="Déconnexion"><i class="fa-solid fa-user-xmark"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>