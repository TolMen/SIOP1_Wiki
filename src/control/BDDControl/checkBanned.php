
<?php

if (!empty($_SESSION["userID"])) {
    $query = $bdd->prepare("SELECT id FROM ban WHERE user_id = ?");
    $query->execute(array($_SESSION["userID"]));
    $user = $query->fetch();

    if (!empty($user["id"])) {
        header("Location: ../UserControl/logout.php");
        exit;
    }
}
