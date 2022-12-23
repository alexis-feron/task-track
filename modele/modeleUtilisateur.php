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
     * @throws Exception
     */
    public function getListesPriv(): array
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        try {
            return $gw->getListesPriv();
        } catch (Exception $e) {
            throw new Exception("Impossible d'acceder aux listes");
        }
    }

}