<?php

session_name("main");
session_start();

include_once 'src/control/BDDControl/connectBDD.php'; // $bdd
include_once 'src/model/UserModel/recupUserModel.php';
include_once 'src/model/UserModel/banCheckUserModel.php';

if (!empty($_SESSION["userID"]) && $_SESSION["userRole"] == "admin") {
    $recupUser = new RecupUserModel();
    $users = $recupUser->getUserInfo($bdd);
} else {
    header("Location: javascript://history.go(-1)");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Inclusion des balises meta -->
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/styleAdmin/userList.css" />
    <title>Civilipédia - Gestion des utilisateurs</title>
</head>

<body>
    <!-- Inclusion de la barre de navigation -->
    <?php include_once 'src/component/navbar.php' ?>

    <!-- En-tête -->
    <header class="header">
        <div class="text">
            <h1>Gestion des utilisateurs</h1>
            <p>Liste des utilisateurs du site.</p>
        </div>
    </header>

    <main class="main-container">
        <div class="container">
            <div class="table-container">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Pseudonyme</th>
                            <th>Rôle</th>
                            <th>Raison</th>
                            <th>Dates</th>
                            <th>Modération</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) { ?>
                            <?php
                            if ($user["user_id"]) {
                                $infoUserBan = new banCheckUserModel();
                                $ban = $infoUserBan->getInfoUserBan($bdd, $user["userid"]);
                            } else {
                                $ban = null;
                            }
                            ?>

                            <tr class="<?php echo $user["user_id"] ? 'table-danger' : ''; ?>">
                                <th scope="row"><?php echo $user["userid"] ?></th>
                                <td><?= $user["username"] ?></td>
                                <td><?= $user["role"] ?></td>
                                <?php if ($user["user_id"]) { ?>
                                    <td><?= !empty($ban["reason"]) ? htmlspecialchars($ban["reason"]) : "-" ?></td>
                                    <td>
                                        <?php
                                        if (!empty($ban["start_date"])) {
                                            $startDate = date("d/m/Y", strtotime($ban["start_date"]));
                                            if ($ban["end_date"]) {
                                                $endDate = date("d/m/Y", strtotime($ban["end_date"]));
                                                echo "Du $startDate au $endDate";
                                            } else {
                                                echo "Depuis le $startDate";
                                            }
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                <?php } else { ?>
                                    <td>-</td>
                                    <td>-</td>
                                <?php } ?>
                                <td>
                                    <?php if ($user["role"] != "admin") { ?>
                                        <?php if ($user["user_id"]) { ?>
                                            <span class="action_deban text-success" data-bs-toggle="modal" data-bs-target="#deban<?php echo $user["userid"]; ?>">
                                                <i class="fas fa-check-circle"></i> Débannir
                                            </span>
                                        <?php } else { ?>
                                            <span class="action_ban text-danger" data-bs-toggle="modal" data-bs-target="#bandef<?php echo $user["userid"]; ?>">
                                                <i class="fas fa-ban"></i> Bannir définitivement
                                            </span><br>
                                            <span class="action_ban text-danger" data-bs-toggle="modal" data-bs-target="#bantemp<?php echo $user["userid"]; ?>">
                                                <i class="fas fa-clock"></i> Bannir temporairement
                                            </span>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                            </tr>

                            <!-- Modales -->
                            <div class="modal fade" id="bandef<?php echo $user["userid"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Bannissement définitif</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="src/control/UserControl/sanction.php?user_id=<?php echo $user["userid"]; ?>&method=ban">
                                                <label>
                                                    <h5>Voulez-vous bannir <?php echo $user["username"]; ?> ?</h5>
                                                </label>
                                                <label for="ReasonID">Raison :</label>
                                                <input class="inputReason" type="text" id="ReasonID" name="reason" required />
                                                <input class="buttonSubmit" type="submit" value="Bannir" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="bantemp<?php echo $user["userid"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Bannissement temporaire</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="src/control/UserControl/sanction.php?user_id=<?php echo $user["userid"]; ?>&method=ban">
                                                <label>
                                                    <h5>Voulez-vous bannir temporairement <?php echo $user["username"]; ?> ?</h5>
                                                </label>
                                                <label for="ReasonID">Raison :</label>
                                                <input class="inputReason" type="text" id="ReasonID" name="reason" required />
                                                <label for="EndDateID">Durée :</label>
                                                <input type="date" id="EndDateID" name="end_date" required />
                                                <input class="buttonSubmit" type="submit" value="Bannir temporairement" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="deban<?php echo $user["userid"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Débannir</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="src/control/UserControl/sanction.php?user_id=<?php echo $user["userid"]; ?>&method=unban">
                                                <label>
                                                    <h5>Voulez-vous débannir <?php echo $user["username"]; ?> ?</h5>
                                                </label>
                                                <input class="buttonSubmit" type="submit" value="Débannir" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Inclusion du pied de page -->
    <?php include 'src/component/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>