<?php

session_name("main");
session_start();
include_once 'src/control/BDDControl/connectBDD.php'; // Connexion à la BDD

if (!empty($_SESSION["userID"]) && $_SESSION["userRole"] == "admin") {
    $query = $bdd->prepare("SELECT id, name, email, subject, message FROM contact");
    $query->execute(array());
    $messages = $query->fetchAll();
} else {
    header("Location: javascript://history.go(-1)");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php include 'src/component/head.php'; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/messagerie.css" />

        <title>Wiki - Messagerie</title>
    </head>

    <body>
        <?php include_once 'src/component/navbar.php' ?>
        <div class="global">
            <h1>Messagerie</h1>
            <div class="container cases">
                <div class="row g-3">
                    <?php foreach ($messages as $message) { ?>
                        <div class="col-12 col-md-3">
                            <div class="case">
                                <a class="trash"
                                    href="./src/control/BDDControl/deleteMessage.php?id=<?php echo $message['id'] ?>"><img
                                        src="./assets/svg/trash.svg" alt="Supprimer" /></a>
                                <h5>De : <?php echo htmlspecialchars($message["name"]); ?></h5>
                                <h6>Sujet : <?php echo htmlspecialchars($message["subject"]); ?></h6><br>
                                <p class="message-overflow"><?php echo htmlspecialchars($message["message"]); ?></p>
                                <button class="col-2 bouton" tabindex="0" data-bs-toggle="modal"
                                    data-bs-target="#<?php echo $message['id'] ?>">Voir</button>
                            </div>
                        </div>
                        <div class="modal fade" id="<?php echo $message['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="modal-title fs-5">
                                            <h5>De : <?php echo htmlspecialchars($message["name"]); ?>
                                                (<?php echo htmlspecialchars($message["email"]); ?>)</h5>
                                            <h6>Sujet : <?php echo htmlspecialchars($message["subject"]); ?></h6>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo htmlspecialchars($message["message"]); ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Fermer</button>
                                        <button type="button" class="btn btn-danger"
                                            onclick="window.location.href = './src/control/BDDControl/deleteMessage.php?id=<?php echo $message['id'] ?>';">Supprimer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- Inclusion du pied de page -->
            <?php include 'src/component/footer.php' ?>
        </div>
    </body>

</html>