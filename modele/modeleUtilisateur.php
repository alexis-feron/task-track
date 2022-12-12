<?php
require("modele/modeleVisiteur.php");
class modeleUtilisateur extends modeleVisiteur {
    public function deconnexion()
    {
        session_destroy();
    }
}