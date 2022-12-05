<?php

class modeleConnexion{
    public function connection(string $login, string $mdp) : Compte
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayCompte(new Connection($dsn, $login, $mdp));
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
        global $dsn, $loginDB, $pswdDB;
        $gw = new GatewayListe(new Connection($dsn, $loginDB, $pswdDB));

        return $gw->getListeParCreateur($page, $nbElements, $pseudo);
    }

    public function getTaches(int $liste, int $page, int $nbElements)
    {
        // Connection à la base de données
        global $dsn, $loginDB, $pswdDB;
        $gw = new GatewayTache(new Connection($dsn, $loginDB, $pswdDB));

        return $gw->getTachesParIDListe($liste, $page, $nbElements);
    }

    public function createTodoList(string $nom) : bool
    {
        global $dsn, $loginDB, $pswdDB;
        $gw = new GatewayListe(new Connection($dsn, $loginDB, $pswdDB));
        if(!$this->estConnecte())
        {
            throw new Exception("Il faut être connecté.e pour créer un Todo List.");
        }
        $pseudo = Validation::netoyerString($_SESSION["login"]);
        if(is_null($pseudo))
        {
            throw new Exception("Erreur avec la valeur enregistré du pseudonyme");
        }
        return $gw->inserer2($nom, $pseudo);
    }

    public function createTask(string $nom, string $comm, int $list) : bool
    {
        global $dsn, $loginDB, $pswdDB;

        $gw = new GatewayTache(new Connection($dsn, $loginDB, $pswdDB));
        return $gw->insererSimple($nom, $comm, $list);
    }

    public function supprimerListe(int $listID) : bool
    {
        global $dsn, $loginDB, $pswdDB;
        $gw = new GatewayListe(new Connection($dsn, $loginDB, $pswdDB));
        return $gw->supprimerAvecListID($listID);
    }
    public function delTask(int $id) : bool
    {
        global $dsn, $loginDB, $pswdDB;
        $gw = new GatewayTache(new Connection($dsn, $loginDB, $pswdDB));
        return $gw->supprimerAvecTacheID($id);
    }

}