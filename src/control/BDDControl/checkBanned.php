
<?php

if (!empty($_SESSION["userID"])) {
    $query = $bdd->prepare("SELECT id FROM ban WHERE user_id = ?");
    $query->execute(array($_SESSION["userID"]));
    $user = $query->fetch();

    if (!empty($_SESSION["userID"])) {
        header("Location: src/control/UserControl/logout.php");
        exit;
    }
}
