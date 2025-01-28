<?php

session_name("main");
session_start();
require_once 'src/control/BDDControl/connectBDD.php'; // $bdd

// Paramètre ID
if (!empty($_POST["id"])) {
	$id = "%".htmlspecialchars($_POST["id"], ENT_QUOTES)."%";
}
else {
    $id = "%";
}
// Paramètre username
if (!empty($_POST["username"])) {
	$username = "%".htmlspecialchars($_POST["username"], ENT_QUOTES)."%";
}
else {
    $username = "%";
}
// Paramètre role
if (!empty($_POST["role"])) {
	$role = "%".htmlspecialchars($_POST["role"], ENT_QUOTES)."%";
}
else {
    $role = "%";
}
// Paramètre isBanned
if (!empty($_POST["isBanned"])) {
	$isBanned = htmlspecialchars($_POST["isBanned"], ENT_QUOTES);
}
else {
    $isBanned = null;
}

// Vérifier si connecté et admin, si oui, procéder
if (!empty($_SESSION["userID"]) && $_SESSION["userRole"] == "admin") {
    // Préparation requête sans isBanned
    $requeteSql = "SELECT users.id as userid, username, role, bans.id, bans.user_id FROM users LEFT JOIN bans ON bans.user_id = users.id WHERE users.id LIKE ? AND username LIKE ? AND role LIKE ?";

    // N'afficher que les bannis
    if ($isBanned == "True") {
        $requeteSql = $requeteSql." AND bans.id IS NOT NULL";
    }
    // N'afficher que les non bannis
    elseif ($isBanned == "False") {
        $requeteSql = $requeteSql." AND bans.id IS NULL";
    }
    // Sinon afficher tous
    $requeteSql = $requeteSql." ORDER BY userid LIMIT 50;";

    $state = $bdd->prepare($requeteSql);
    $state->execute(array($id, $username, $role));
    $users = $state->fetchAll();

}
// Sinon, revenir à la page précedente
else {
    header("Location: javascript://history.go(-1)");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <!-- Balises méta essentielles -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="mobile-web-app-capable" content="yes" />

        <!-- Informations SEO -->
        <meta name="keywords" content="###"> <!-- Mettre des mots clés -->
        <meta name="description" content="###
        Un projet SLAM réalisé dans le cadre du BTS SIO en équipe de 3." /> <!-- Mettre une description -->
        <meta name="author" content="Nolan / Kelly / Jessy" />

        <!-- Icône du site -->
        <link rel="icon" type="favicon.ico" sizes="16x16" href="###" /> <!-- Trouver un favicon -->

        <!-- Feuilles de style externes -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />

        <!-- Feuilles de style personnalisées -->
        <link rel="stylesheet" href="css/baseStyle.css" />
        <link rel="stylesheet" href="css/userListStyle.css" />

        <title>Wiki - Liste des utilisateurs</title>
    </head>


    <body>
        <!-- Inclusion de la barre de navigation -->
        <?php include 'src/component/navbar.php' ?>

        <!-- Code -->
        <div class='userList row'>
            <div class="queryUsers col-10">
                <form method="POST" action="user_list.php">
                    <label for="userID">ID :</label>
                    <input class="inputID" type="number" min="0" id="userID" name="id"/>

                    <label for="usernameID">Identifiant :</label>
                    <input class="inputUsername" type="text" id="usernameID" name="username"/>

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

                    <input class="buttonSubmit" type="submit" value="Rechercher"/>
                </form>
            </div>
            <div class="UserCase active col-6">
                <div class="col-3">ID</div>
                <div class="col-3">Identifiant</div>
                <div class="col-3">Rôle</div>
                <div class="col-3">Banni ?</div>
            </div>
            <div class="col-1"></div>
            <div class="UserCase active col-3"></div>
            <?php 
                foreach ($users as $user) {
                    echo "<div class='userCase col-6'>";
                        // ID
                        echo "<div class='col-3'>".$user["userid"]."</div>";
                        // username
                        echo "<div class='col-3'>".$user["username"]."</div>";
                        // role
                        if ($user["role"] == "user") {
                            echo "<div class='col-3'>Utilisateur</div>";
                        }
                        elseif ($user["role"] == "admin") {
                            echo "<div class='col-3'>Administrateur</div>";
                        }
                        else {
                            echo "<div class='col-3'>Inconnu</div>";
                        }
                        // isBanned
                        if ($user["user_id"]) {
                            echo "<div class='col-3'>&nbsp;&nbsp;Oui<img src='assets/img/eye_popup.png' alt='+'  data-bs-toggle='modal' data-bs-target='#imagePopup' style='cursor: pointer; width: 15px;'></div>";

                            echo "<div class='modal fade' id='imagePopup' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                                echo "<div class='modal-dialog'>";
                                    echo "<div class='modal-content'>";
                                        echo "<div class='modal-header'>";
                                            echo "<h5 class='modal-title' id='exampleModalLabel'>Sanction actuelle</h5>";
                                            echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                                        echo "</div>";
                                        echo "<div class='modal-body'>";
                                        // Intérieur
                                            $state = $bdd->prepare("SELECT * FROM bans WHERE user_id = ? ORDER BY start_date LIMIT 1");
                                            $state->execute(array($user["user_id"]));
                                            $ban = $state->fetch();

                                            // Si ban def
                                            if (empty($ban["end_date"])) {
                                                echo "<br><h5>Bannissement définitif</h5>"."<br>";
                                                echo "Raison : ".$ban["reason"]."<br>";
                                                echo "Date : ".$ban["start_date"];
                                            }
                                            else {
                                                echo "<br><h5>Bannissement temporaire</h5>"."<br>";
                                                echo "Raison : ".$ban["reason"]."<br>";
                                                echo "Date : ".$ban["start_date"]."<br>";
                                                echo "Fin : ".$ban["end_date"]."<br><br>";
                                            }


                                        // Intérieur
                                        echo "</div>";
                                        echo "<div class='modal-footer'>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        }
                        else {
                            echo "<div class='col-3'>Non</div>";
                        }
                    echo "</div>";
                    echo "<div class='col-1'></div>";

                    // Code pour bannir ou débannir
                    echo "<div class='userCase col-3'>";
                    echo "</div>";
                }
            ?>
        </div>

        <!-- Inclusion du pied de page -->
        <?php include 'src/component/footer.php' ?>

        <!-- Liens vers les scripts JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous">
        </script>
    </body>
</html>
