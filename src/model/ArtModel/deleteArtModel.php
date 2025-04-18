<?php

include_once '../../control/BDDControl/connectBDD.php';

class DeleteArtModel {

    public function firstAuthorArt(PDO $bdd, $articleID) {
        $firstAuthorId = $bdd->prepare("SELECT firstAuthor FROM article WHERE id = ?");
        $firstAuthorId->execute(array($articleID));
        return $firstAuthorId->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteArt(PDO $bdd, $articleID) {
        $state = $bdd->prepare("DELETE FROM article WHERE id = ?");
        $state->execute(array($articleID));
    }
}