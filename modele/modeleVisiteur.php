<?php
require("dal/gateway/GatewayListe.php");
require("dal/gateway/GatewayCompte.php");
require("dal/Connexion.php");
class modeleVisiteur{

    /**
     * @brief permet à l'utilisateur de se connecter s'il a déja un compte
     * @throws Exception
     */
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
        //verifie si le mot de passe est le bon
        if($motPasse!=$compte->getMotDePasse())
        {
            echo 'Mot de passe incorrect';
            throw new Exception("Mot de passe incorrect");
        }
        //creer une session
        $_SESSION["login"]=$compte->getPseudonyme();
        $_SESSION["listes"]=$compte->getListes();
        return $compte;
    }
    /**
     * @brief permet de savoir si la personne est connecté(=utilisateur) ou non (=visiteur)
     */
    public function estConnecte() : bool
    {
        if(isset($_SESSION["login"]) && !empty($_SESSION["login"]))
        {
            return true;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function getListes(): array
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        return $gw->getListes();
    }

    public function getTaches(int $liste): array
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));

        return $gw->getTache($liste);
    }

    /**
     * @brief permet de creer une To-Do List
    */
    public function creerListe(string $nom,bool $pub) : bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        //associe le createur de la liste à son login s'il est connecté, sinon visiteur le remplacera
        if(isset($_SESSION["login"])){
            $crea=$_SESSION["login"];
        }else{
            $crea="Visiteur";
            $pub=true;
        }
        //créé la liste et l'insère en base de donnée'
        $liste=new Liste(rand(1000,2000000),$nom,$crea,$pub,array());
        return $gw->inserer($liste);
    }

    /**
     * @brief permet de supprimer une To-Do List
     */
    public function supprimerListe(int $listID) : bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        //appel à la gateway pour supprimer la To-Do Liste
        return $gw->supprimer($listID);
    }

    /**
     * @brief permet de creer une tache dans la To-Do List passée en paramètre
     */
    public function creerTache(string $nom, int $liste) : bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
        //appel à la gateway pour creer la To-Do List dans le base de donnée
        return $gw->inserer(rand(1000,2000000),$nom, $liste);
    }

    /**
     * @brief permet de changer le statut de la tache. Si elle est faite elle devient à faire et inversement
     */
    public function tacheFaite(int $id): bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
        //appel à la gateway pour changer le statut de la To-Do List dans le base de donnée
        return $gw->tacheFaite($id);
    }

    /**
     * @brief permet de supprimer une tache de sa To-Do list
     */
    public function supprimerTache(int $id) : bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
        return $gw->supprimer($id);
    }

    /**
     * @brief permet de modifier le nom de la tache
     */
    public function modifierNomTache(int $id, string $nouveauNom)
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
        $gw->modifier($id, $nouveauNom);
    }

    /**
     * @brief permet de renommer une To-Do List
     */
    public function modifierNomListe(int $id, string $nouveauNom){
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        $gw->modifier($id, $nouveauNom);
    }

    public function sInscrire(string $pseudo, string $email,string $mdp1)
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayCompte(new Connexion($dsn, $login, $mdp));
        $gw->creerCompte($pseudo, $email, $mdp1);
    }


}