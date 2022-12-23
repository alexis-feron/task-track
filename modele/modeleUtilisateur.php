<?php
require("modele/modeleVisiteur.php");
class modeleUtilisateur extends modeleVisiteur {

    /**
     * @brief permet de détruire une session lancée
     */
    public function deconnexion()
    {
        session_destroy();
    }

    /**
     * @brief permet d'avoir les listes privées de l'utilisateur
     */
    public function getListesPriv()
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        return $gw->getListesPriv();
    }



}