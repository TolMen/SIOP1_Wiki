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
    <!-- Inclusion des balise meta -->
    <?php include 'src/component/head.php'; ?>
    <link rel="stylesheet" href="css/listStyle.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Civilipédia - Gestion des utilisateurs</title>
</head>


<body>
<!-- Inclusion de la barre de navigation -->
<?php include_once 'src/component/navbar.php' ?>

<!-- Code -->
<table class="table table-striped table-hover">
    <thead>
    <div class="container">
        <a class="text-danger" href="src/control/UserControl/resetAllUser.php">Réinitialiser les utilisateurs</a>
    </div>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Pseudonyme</th>
        <th scope="col">Rôle</th>
        <th scope="col">Raison</th>
        <th scope="col">Dates</th>
        <th scope="col">Modération</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user) { ?>
        <?php
        if ($user["user_id"]) {
            $infoUserBan = new banCheckUserModel();
            $ban = $infoUserBan->getInfoUserBan($bdd, $user["userid"]);
        }
        else {
            $ban = null;
        }
        ?>

        <?php
        if ($user["user_id"]) {
            echo "<tr class='table-danger'>";
        }
        else {
            echo "<tr>";
        }
        ?>
        <th scope="row"><?php echo $user["userid"] ?></th>
        <td><?php echo $user["username"] ?></td>
        <td><?php echo $user["role"] ?></td>
        <?php if ($user["user_id"]) { ?>
            <td><?php echo $ban["reason"] ?></td>
            <td>Du <?php echo $ban["start_date"] ?> au <?php echo $ban["end_date"] ?></td>
        <?php } else { ?>
            <td></td>
            <td></td>
        <?php } ?>
        <?php if ($user["user_id"]) { ?>
            <td><span class="action_deban" data-bs-toggle="modal" data-bs-target="#deban<?php echo $user["userid"]; ?>">Débannir</span></td>
        <?php } else { ?>
            <td>
                <span class="action_ban" data-bs-toggle="modal" data-bs-target="#bandef<?php echo $user["userid"]; ?>">Bannir définitivement</span><br>
                <span class="action_ban" data-bs-toggle="modal" data-bs-target="#bantemp<?php echo $user["userid"]; ?>">Bannir temporairement</span>
            </td>
        <?php } ?>
        </tr>

        <!-- Popups -->
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
                            </label><br><br>
                            <label for="ReasonID">Raison :</label><br>
                            <input class="inputReason" type="text" id="ReasonID" name="reason" required /><br><br>
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
                            </label><br><br>
                            <label for="ReasonID">Raison :</label><br>
                            <input class="inputReason" type="text" id="ReasonID" name="reason" required /><br>

                            <label for="EndDateID">Durée :</label><br>
                            <input type="date" id="EndDateID" name="endDate" required /><br><br>

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
                            </label><br><br>
                            <input class="buttonSubmit" type="submit" value="Débannir" /><br><br>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
    </tbody>
</table>

<!-- Inclusion du pied de page -->
<?php include 'src/component/footer.php' ?>

<!-- Liens vers les scripts JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
</body>

</html>