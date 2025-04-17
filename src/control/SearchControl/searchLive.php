<?php
session_name("main");
session_start();

include_once '../BDDControl/connectBDD.php';
include_once '../../model/SearchModel/getSearchModel.php';

header('Content-Type: application/json');

if (!isset($_GET['q']) || empty($_GET['q'])) {
    echo json_encode([]);
    exit;
}

$motCle = htmlspecialchars($_GET['q']);
$searchModel = new getSearchModel();
$resultats = $searchModel->getRecherche($bdd, $motCle);

// Ne retourne que le strict nécessaire
echo json_encode(array_map(function ($article) {
    return [
        'id' => $article['id'],
        'title' => $article['title']
    ];
}, $resultats));
