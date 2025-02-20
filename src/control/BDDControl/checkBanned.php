
<?php

if (!empty($_SESSION["userID"])) {
    $querybanned = $bdd->prepare("SELECT id FROM ban WHERE user_id = ?");
    $querybanned->execute(array($_SESSION["userID"]));
    $isuserbanned = $querybanned->fetch();

    if (!empty($isuserbanned["id"])) {
        if (file_exists("./src/control/UserControl/logout.php")) {
            header("Location: ./src/control/UserControl/logout.php");
        } elseif (file_exists("../src/control/UserControl/logout.php")) {
            header("Location: ../src/control/UserControl/logout.php");
        }
    }
}
