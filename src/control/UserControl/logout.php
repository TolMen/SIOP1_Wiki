<?php

session_name("main");
session_start();
session_unset();
session_destroy();

if (htmlspecialchars(!empty($_GET["banned"]), ENT_QUOTES)) {
    header("Location: ../../../login.php?banned=True");
} else {
    header("Location: ../../../home.php");
}

exit;
