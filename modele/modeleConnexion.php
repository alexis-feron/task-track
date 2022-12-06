<?php

class modeleConnexion{
    public function connection(string $login, string $mdp) : Compte
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


    public function getLists(string $pseudo, int $page, int $nbElements)
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));

        return $gw->getListe($page, $nbElements, $pseudo);
    }

    public function getTaches(int $liste, int $page, int $nbElements)
    {
        // Connection à la base de données
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));

        return $gw->getTache($liste, $page, $nbElements);
    }

    public function createTodoList(string $nom) : bool
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

    public function createTask(string $nom, string $comm, int $list) : bool
    {
        global $dsn, $login, $mdp;

        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
        return $gw->inserer($nom, $comm, $list);
    }

    public function supprimerListe(int $listID) : bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        return $gw->supprimer($listID);
    }
    public function delTask(int $id) : bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
        return $gw->supprimer($id);
    }

}