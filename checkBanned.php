<?php

include_once 'src/model/UserModel/banCheckUserModel.php';

if (!empty($_SESSION["userID"])) {

    $banCheckUser = new banCheckUserModel();
    $isuserbanned = $banCheckUser->checkUserBan($bdd, $_SESSION["userID"]);
    
    if (!empty($isuserbanned["id"])) {
        if (file_exists("./src/control/UserControl/logout.php")) {
            header("Location: ./src/control/UserControl/logout.php?banned=True");
        } elseif (file_exists("../src/control/UserControl/logout.php")) {
            header("Location: ../src/control/UserControl/logout.php");
        }
    }
}
