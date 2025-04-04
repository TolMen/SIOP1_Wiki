

<?php

$query = $bdd->prepare("SELECT id, name, email, subject, message FROM contact");
$query->execute(array());
$messages = $query->fetchAll();



