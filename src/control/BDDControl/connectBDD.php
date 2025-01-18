<?php

/*
- Inclusion de fichier nécessaire
*/
$config = require dirname(__DIR__, 3) . '/config/configBDD.php';

/*
- Extraction des paramètres de connexion de la BDD
*/
$host = $config['host'];
$dbname = $config['dbname'];
$admin = $config['admin'];
$pass = $config['pass'];

/*
- Création d'une instance PDO, puis utilise les paramètres de configuration de la BDD, puis gère le lancement d'exception en cas d'erreur
*/
$bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;", $admin, $pass);
