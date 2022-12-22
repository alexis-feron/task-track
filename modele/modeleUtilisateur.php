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

    public function creerListe(string $nom) : bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        if(!$this->estConnecte())
        {
            throw new Exception("Il faut être connecté.e pour créer un Todo List.");
        }
        $pseudo = Validation::nettoyerString($_SESSION["login"]);
        if(is_null($pseudo))
        {
            throw new Exception("Erreur avec le pseudo");
        }
        return $gw->inserer2($nom, $pseudo);
    }



}