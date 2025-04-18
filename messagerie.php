<!-- messagerie.php -->
<?php
session_name("main");
session_start();

include_once 'src/control/BDDControl/connectBDD.php';

if (!empty($_SESSION["userID"]) && $_SESSION["userRole"] == "admin") {
    require_once 'src/control/MessControl/getAllMess.php';
} else {
    header("Location: javascript://history.go(-1)");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/styleAdmin/message.css" />
    <link rel="stylesheet" href="css/stylePopUp/stylePopUp.css">
    <title>Civilipédia - Messagerie</title>
</head>

<body>
    <?php include_once 'src/component/navbar.php' ?>

    <header class="header">
        <div class="text">
            <h1>Messagerie</h1>
            <p>Messages envoyés par les utilisateurs.</p>
        </div>
    </header>

    <main class="main-container">
        <section class="container">
            <div class="row g-4">
                <?php foreach ($messages as $message) { ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="message-card">
                            <a href="src/control/BDDControl/deleteMessage.php?id=<?= $message['id'] ?>" class="delete-badge" title="Supprimer le message">
                                <i class="fa-solid fa-trash" style="color: red;"></i>
                            </a>
                            <div class="content">
                                <h3><?= htmlspecialchars($message['subject']) ?></h3>
                                <p><strong>De :</strong> <?= htmlspecialchars($message['name']) ?></p>
                                <button class="btn btn-outline-dark btn-sm mt-2 show-popup"
                                    data-nom="<?= htmlspecialchars($message['name']) ?>"
                                    data-email="<?= htmlspecialchars($message['email']) ?>"
                                    data-objet="<?= htmlspecialchars($message['subject']) ?>"
                                    data-message="<?= htmlspecialchars($message['message']) ?>">
                                    Lire
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="mess<?= $message['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <h5 class="modal-title"><?= htmlspecialchars($message['subject']) ?></h5>
                                        <small>De : <?= htmlspecialchars($message['name']) ?> (<?= htmlspecialchars($message['email']) ?>)</small>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                </div>
                                <div class="modal-body">
                                    <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <a href="src/control/BDDControl/deleteMessage.php?id=<?= $message['id'] ?>" class="btn btn-danger">Supprimer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>

        <?php include 'src/component/footer.php'; ?>

        <div id="popup" class="popup">
            <div class="popup-content">
                <p id="popup-message"></p>
                <button id="closePopup">Fermer</button>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/messagePopup.js"></script>

</body>

</html>