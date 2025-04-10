<footer class="bg-light text-dark py-4 custom-footer">
    <div class="container text-center">
        <p class="mb-0">
            &copy;
            <!-- Affiche l'année en cours -->
            <?php
            date_default_timezone_set("Europe/Paris");
            echo date("Y");
            ?>
            Nolan / Kelly / Jessy | Tous les droits sont réservés. <br />
            <!-- Description du projet -->
            Ce projet a été réalisé en équipe de 3, dans le cadre de mon apprentissage pour le BTS SIO.
        </p>
    </div>
</footer>