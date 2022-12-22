<?php
require("dal/gateway/GatewayListe.php");
require("dal/gateway/GatewayCompte.php");
require("dal/Connexion.php");
class modeleVisiteur{
    public function connexion(string $log, string $motPasse) : Compte
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayCompte(new Connexion($dsn, $login, $mdp));
        $compte = $gw->getCompte($log);
        if($compte==null)
        {
            echo 'Login incorrect';
            throw new Exception("Login incorrect");
        }
        //if(!password_verify($motPasse, $compte->getMotDePasse()))
        if($motPasse!=$compte->getMotDePasse())
        {
            echo 'Mot de passe incorrect';
            throw new Exception("Mot de passe incorrect");
        }

        $_SESSION["login"]=$compte->getPseudonyme();
        $_SESSION["listes"]=$compte->getListes();
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

    public function creerListe(string $nom,bool $pub) : bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        if(isset($_SESSION["login"])){
            $crea=$_SESSION["login"];
        }else{
            $crea="Visiteur";
            $pub=true;
        }
        $liste=new Liste(rand(1000,2000000),$nom,$crea,$pub,array());
        return $gw->inserer($liste);
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
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
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
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        return $gw->getListe($id)->getNom();
    }

    public function getMaxPageTaches(int $listeID, int $nbElements) : int
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
        $nbTotal = $gw->getNbTacheParListeID($listeID);
        return ceil($nbTotal/$nbElements);
    }


}