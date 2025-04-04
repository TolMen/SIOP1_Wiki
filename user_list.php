<?php

session_name("main");
session_start();

include_once 'src/control/BDDControl/connectBDD.php'; // $bdd
include_once 'src/model/UserModel/recupUserModel.php';
include_once 'src/model/UserModel/banCheckUserModel.php';

$id = !empty($_POST["id"]) ? htmlspecialchars($_POST["id"], ENT_QUOTES) : "%";
$username = !empty($_POST["username"]) ? "%" . htmlspecialchars($_POST["username"] . "%", ENT_QUOTES) : "%";
$role = !empty($_POST["role"]) ? htmlspecialchars($_POST["role"], ENT_QUOTES) : "%";
$isBanned = !empty($_POST["isBanned"]) ? htmlspecialchars($_POST["isBanned"], ENT_QUOTES) : null;

if (!empty($_SESSION["userID"]) && $_SESSION["userRole"] == "admin") {
    $recupUser = new RecupUserModel();
    $users = $recupUser->getUserInfo($bdd, $isBanned, $id, $username, $role);
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

        <title>Wiki - Gestion des utilisateurs</title>
    </head>


<body>
    <!-- Inclusion de la barre de navigation -->
    <?php include_once 'src/component/navbar.php' ?>

    <!-- Code -->
    <div class='userList row'>
        <div class="queryUsers col-10">
            <form method="POST" action="user_list.php">
                <label for="userID">ID :</label>
                <input class="inputID" type="number" min="0" id="userID" name="id" />

                <label for="usernameID">Identifiant :</label>
                <input class="inputUsername" type="text" id="usernameID" name="username" />

                <label for="roleID">Rôle :</label>
                <select id="roleID" name="role">
                    <option></option>
                    <option value="user">Utilisateur</option>
                    <option value="admin">Administrateur</option>
                </select>

                <label for="isBannedID">Banni ? :</label>
                <select id="isBannedID" name="isBanned">
                    <option></option>
                    <option value="True">Oui</option>
                    <option value="False">Non</option>
                </select>

                    <input class="buttonSubmit" type="submit" value="Rechercher" />
                </form>
            </div>
            <div class="UserCase active col-6">
                <div class="col-3">ID</div>
                <div class="col-3">Identifiant</div>
                <div class="col-3">Rôle</div>
                <div class="col-3">Banni ?</div>
            </div>
            <div class="col-1"></div>
            <div class="col-1">Ban définitif</div>
            <div class="col-1">Ban temporaire</div>
            <div class="col-1">Débannir</div>

            <?php
            foreach ($users as $user) {
                // Vérifier si l'utilisateur est banni
                $isBannedClass = $user["user_id"] ? "banned" : "";
                ?>
                <div class="userCase col-6 <?php echo $isBannedClass; ?>">
                    <!-- ID -->
                    <div class="col-3"><?php echo $user["userid"] ?></div>
                    <!-- Username -->
                    <div class="col-3"><?php echo $user["username"] ?></div>
                    <!-- Role -->
                    <?php if ($user["role"] == "user") { ?>
                        <div class="col-3">Utilisateur</div>
                    <?php } elseif ($user["role"] == "admin") { ?>
                        <div class="col-3">Administrateur</div>
                    <?php } ?>
                    <!-- IsBanned -->
                    <?php if ($user["user_id"]) { ?>
                        <div class="col-3">&nbsp;&nbsp;Oui<img src="assets/img/eye_popup.png" alt="+" data-bs-toggle="modal"
                                data-bs-target="#imagePopup<?php echo $user["userid"]; ?>" style="width: 15px;" class="eye">
                        </div>
                        <div class="modal fade" id="imagePopup<?php echo $user["userid"]; ?>" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <!-- Titre -->
                                        <h5 class="modal-title" id="exampleModalLabel">Sanction actuelle</h5><button
                                            type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Intérieur -->
                                        <?php
                                        $infoUserBan = new banCheckUserModel();
                                        $ban = $infoUserBan->getInfoUserBan($bdd, $user["userid"]);

                                    // Si ban def
                                    if (empty($ban["end_date"])) { ?>
                                        <br>
                                        <h5>Bannissement définitif</h5>
                                        Raison : "<?php echo $ban["reason"] ?>"<br>
                                        Date : <?php echo date("d/m/Y", strtotime($ban["start_date"])) ?><br><br>
                                    <?php }
                                    // Si ban temp
                                    else { ?>
                                        <br>
                                        <h5>Bannissement temporaire</h5>
                                        Raison : "<?php echo $ban["reason"] ?>"<br><br>
                                        Date : <?php echo date("d/m/Y", strtotime($ban["start_date"])) ?><br>
                                        Fin : <?php echo date("d/m/Y", strtotime($ban["end_date"])) ?><br><br>
                                    <?php } ?>
                                </div>
                                <div class="modal-footer"></div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-12 col-sm-3">Non</div>
                <?php } ?>

                <!-- Séparation -->
            </div>
            <div class="col-1"></div>

                <!-- Code pour bannir ou débannir -->
                <div class="userCase col-3">
                    <!-- Bannissement définitif -->
                    <?php if ($user["user_id"] == null && $user["role"] != "admin") { ?>
                        <div class="col-3"><img src="assets/img/bandef.png" alt="+" data-bs-toggle="modal"
                                data-bs-target="#bandef<?php echo $user["userid"]; ?>" style="cursor: pointer; width: 40px;">
                        </div>
                        <div class="modal fade" id="bandef<?php echo $user["userid"]; ?>" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <!-- Titre -->
                                        <h5 class="modal-title" id="exampleModalLabel">Bannissement définitif</h5><button
                                            type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Intérieur -->
                                        <form method="POST"
                                            action="src/control/UserControl/sanction.php?user_id=<?php echo $user["userid"] ?>&method=ban">
                                            <label>
                                                <h5>Voulez-vous bannir <?php echo $user["username"] ?> ?</h5>
                                            </label><br><br>
                                            <label for="ReasonID">Raison :</label><br>
                                            <input class="inputReason" type="text" id="ReasonID" name="reason" required /><br>

                                            <input class="buttonSubmit" type="submit" value="Bannir" />
                                        </form>
                                    <?php } else { ?>
                                        <div class="col-3"><img class="cantban" src="assets/img/nobandef.png"
                                                style="width: 40px;"></div>
                                        <div>
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <?php } ?>
                                                </div>
                                                <div class="modal-footer"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bannissement temporaire -->
                                    <?php if ($user["user_id"] == null && $user["role"] != "admin") { ?>
                                        <div class="col-3"><img src="assets/img/bantemp.png" alt="+" data-bs-toggle="modal" data-bs-target="#bantemp<?php echo $user["userid"]; ?>" style="cursor: pointer; width: 40px;"></div>
                                        <div class="modal fade" id="bantemp<?php echo $user["userid"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <!-- Titre -->
                                                        <h5 class="modal-title" id="exampleModalLabel">Bannissement temporaire</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Intérieur -->
                                                        <form method="POST"
                                                            action="src/control/UserControl/sanction.php?user_id=<?php echo $user["userid"] ?>&method=ban">
                                                            <label>
                                                                <h5>Voulez-vous bannir temporairement
                                                                    <?php echo $user["username"] ?> ?
                                                                </h5>
                                                            </label><br><br>
                                                            <label for="ReasonID">Raison :</label><br>
                                                            <input class="inputReason" type="text" id="ReasonID" name="reason"
                                                                required /><br>

                                                            <label for="end_dateID">Fin :</label>
                                                            <input type="date" id="end_dateID" name="end_date"
                                                                required /><br><br>

                                                            <input class="buttonSubmit" type="submit" value="Bannir" />
                                                        </form>
                                                    <?php } else { ?>
                                                        <div class="col-3"><img class="cantban" src="assets/img/nobantemp.png"
                                                                style="width: 40px;"></div>
                                                        <div>
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                    <?php } ?>
                                                                    </div>
                                                                    <div class="modal-footer"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <!-- Débanissement -->
                                                    <?php if ($user["user_id"] != null && $user["role"] != "admin") { ?>
                                                        <div class="col-3"><img src="assets/img/unban.png" alt="+"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#unban<?php echo $user["userid"]; ?>"
                                                                style="cursor: pointer; width: 40px;"></div>
                                                        <div class="modal fade" id="unban<?php echo $user["userid"]; ?>"
                                                            tabindex="-1" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <!-- Titre -->
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Débannissement</h5><button type="button"
                                                                            class="btn-close" data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Intérieur -->
                                                                        <form method="POST"
                                                                            action="src/control/UserControl/sanction.php?user_id=<?php echo $user["userid"] ?>&method=unban">
                                                                            <label>
                                                                                <h5>Voulez-vous débannir
                                                                                    <?php echo $user["username"] ?> ?
                                                                                </h5>
                                                                            </label><br><br>
                                                                            <input class="buttonSubmit" type="submit"
                                                                                value="Débannir" />
                                                                        </form>
                                                                    <?php } else { ?>
                                                                        <div class="col-3"><img class="cantban"
                                                                                src="assets/img/nounban.png"
                                                                                style="width: 40px;"></div>
                                                                        <div>
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    </div>
                                                                </div>

                                                                <!-- Inclusion du pied de page -->
                                                                <?php include 'src/component/footer.php' ?>

                                                                <!-- Liens vers les scripts JavaScript -->
                                                                <script
                                                                    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                                                                    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                                                                    crossorigin="anonymous">
                                                                </script>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
    </div>
</body>

</html>