<?php
require("dal/gateway/GatewayListe.php");
require("dal/gateway/GatewayCompte.php");
require("dal/Connexion.php");
class modeleVisiteur{

    /**
     * @brief permet à l'utilisateur de se connecter s'il a déja un compte
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

    public function getListes()
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        return $gw->getListes();
    }

    public function getTaches(int $liste)
    {
        // Connection à la base de données
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
        if(isset($_SESSION["login"])){
            $crea=$_SESSION["login"];
        }else{
            $crea="Visiteur";
            $pub=true;
        }
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
        return $gw->supprimer($listID);
    }

    /**
     * @brief permet de creer une tache dans la To-Do List passée en paramètre
     */
    public function creerTache(string $nom, int $liste) : bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
        return $gw->inserer(rand(1000,2000000),$nom, $liste);
    }

    /**
     * @brief permet de changer le statu de la tache. Si elle est faite elle devient à faire et inversement
     */
    public function tacheFaite(int $id): bool
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
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
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
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

    /**
     * @brief
     */
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

    /**
     * @brief renvoie le nom de la liste
     */
    public function getNomListe(int $id): string
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayListe(new Connexion($dsn, $login, $mdp));
        return $gw->getListe($id)->getNom();
    }

    /**
     * @brief
     */
    public function getMaxPageTaches(int $listeID, int $nbElements) : int
    {
        global $dsn, $login, $mdp;
        $gw = new GatewayTache(new Connexion($dsn, $login, $mdp));
        $nbTotal = $gw->getNbTacheParListeID($listeID);
        return ceil($nbTotal/$nbElements);
    }


}