<?php
require("modele/modeleVisiteur.php");
class modeleUtilisateur extends modeleVisiteur {
    public function deconnexion()
    {
        session_destroy();
    }

    public function getListesPriv()
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        return $gw->getListesPriv();
    }



}