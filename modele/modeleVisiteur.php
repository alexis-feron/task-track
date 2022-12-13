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

    public function getListes(int $page, int $nbElements)
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));

        return $gw->getListe($page, $nbElements);
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
            throw new Exception("Erreur avec la valeur enregistré du pseudonyme");
        }
        return $gw->inserer($nom, $pseudo);
    }

    public function modifierListe(int $idListe, string $nouveauNom)
    {
        global $dsn, $loginDB, $pswdDB;
        $gw = new ListeGateway(new Connection($dsn, $loginDB, $pswdDB));
        return $gw->modiferNomListe($idListe, $nouveauNom);
    }


    public function supprimerListe(int $listID) : bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        return $gw->supprimer($listID);
    }

    public function creerTache(string $nom, string $comm, int $list) : bool
    {
        global $dsn, $login, $mdp;

        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
        return $gw->inserer($nom, $comm, $list);
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

}