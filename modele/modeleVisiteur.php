<?php
require("dal/gateway/GatewayListe.php");
require("dal/gateway/GatewayCompte.php");
require("dal/Connexion.php");
class modeleVisiteur{
    public function connexion(string $login, string $mdp) : Compte
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayCompte(new Connexion($dsn, $login, $mdp));
        $compte = $gw->getCompte($login);
        if($compte == null)
        {
            throw new Exception("Login ou mot de passe incorrect");
        }
        if(!password_verify($mdp, $compte->getMotDePasse()))
        {
            throw new Exception("Login ou mot de passe incorrect");
        }

        $_SESSION["login"] = $compte->getPseudonyme();
        $_SESSION["Lists"] = $compte->getListes();
        return $compte;
    }

    public function estConnecte() : bool
    {
        if(isset($_SESSION["login"]) && !empty($_SESSION["login"]))
        {
            return true;
        }
        return false;
    }

    public function getListes()
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        return $gw->getListes();
    }

    public function getTaches(int $liste, int $page, int $nbElements)
    {
        // Connection à la base de données
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));

        return $gw->getTache($liste, $page, $nbElements);
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

    public function supprimerListe(int $listID) : bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        return $gw->supprimer($listID);
    }

    public function creerTache(string $nom, int $list) : bool
    {
        global $dsn, $login, $mdp;

        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
        return $gw->inserer($nom, $list);
    }

    public function tacheFaite(int $id): bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
        return $gw->modifier($gw->getTache($id));
    }

    public function supprimerTache(int $id) : bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
        return $gw->supprimer($id);
    }

    public function modifierNomTache(int $id, string $nouveauNom)
    {
        global $dsn, $loginDB, $pswdDB;
        $gw = new GatewayListe(new Connexion($dsn, $loginDB, $pswdDB));
        $gw->modifier($id, $nouveauNom);
    }
    public function modifierNomListe(int $id, string $nouveauNom){
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        $gw->modifier($id, $nouveauNom);

    }
    public function getMaxPageListes(string $createur, int $nbElements) : int
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        if ($createur==""){
            return 0;
        }
        $nbTotal = $gw->getNbListesParCreateur($createur);
        return ceil($nbTotal/$nbElements);
    }

    public function getNomListe(int $id): string
    {
        global $dsn, $loginDB, $pswdDB;
        $gw = new GatewayListe(new Connexion($dsn, $loginDB, $pswdDB));
        return $gw->getListe($id)->getNom();
    }

    public function getMaxPageTaches(int $listeID, int $nbElements) : int
    {
        global $dsn, $loginDB, $pswdDB;
        $gw = new GatewayTache(new Connexion($dsn, $loginDB, $pswdDB));
        $nbTotal = $gw->getNbTacheParListeID($listeID);
        return ceil($nbTotal/$nbElements);
    }


}