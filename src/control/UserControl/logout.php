<?php

session_name("main");
session_start();
session_unset();
session_destroy();
header("Location: ../../../home.php");
exit;
