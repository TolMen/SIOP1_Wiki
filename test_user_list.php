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

    <title>Civilipédia - Gestion des utilisateurs</title>
</head>


<body>
<!-- Inclusion de la barre de navigation -->
<?php include_once 'src/component/navbar.php' ?>

<!-- Code -->
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Pseudonyme</th>
            <th scope="col">Rôle</th>
            <th scope="col">Raison</th>
            <th scope="col">Date début</th>
            <th scope="col">Date fin</th>
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
        <tr>
            <th scope="row"><?php echo $user["id"] ?></th>
            <td><?php echo $user["username"] ?></td>
            <td><?php echo $user["role"] ?></td>
            <?php if ($user["user_id"]) { ?>
                <td><?php echo $ban["reason"] ?></td>
                <td><?php echo $ban["start_date"] ?></td>
                <td><?php echo $ban["end_date"] ?></td>
            <?php } else { ?>
                <td></td>
                <td></td>
                <td></td>
            <?php } ?>
            <td>AAA</td>
        </tr>
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