<?php

require_once("dal/gateway/GatewayListe.php");
require_once("metier/Compte.php");

class GatewayCompte
{
    private $conn;

    public function __construct(Connexion $conn)
    {
        $this->conn = $conn;
    }

    /**
     * @brief permet à un visiteur de creer un compte
     */
    public function CreerCompte(string $pseudo, string $mdp) : bool
    {
        $query = "INSERT INTO Utilisateur(pseudo, motDePasse) VALUSES(:p, :m)";
        return $this->conn->executeQuery($query, array(
            ":p" => array($pseudo, PDO::PARAM_STR),
            ":m" => array($mdp, PDO::PARAM_STR)));
    }

    /**
     * @brief permet à un utilisateur de modifier son mot de passe et son pseudo
     */
    public function modifier(Compte $compteModif)
    {
        $query = "UPDATE Utilisateur SET pseud=:p, motDePasse=:m";
        return $this->conn->executeQuery($query, array(
            ":p" => array($compteModif->getPseudonyme(), PDO::PARAM_STR),
            ":m" => array($compteModif->getMotDePasse(), PDO::PARAM_STR)));

    }

    /**
     * @brief permet à un utilisateur de supprimer définitivement son compte de la base de donnée
     */
    public function supprimer(Compte $compteSuppr)
    {
        $query = "DELETE FROM Utilisateur WHERE pseudo=:i";
        return $this->conn->executeQuery($query, array(
            ":i" => array($compteSuppr->getPseudonyme(), PDO::PARAM_INT)));
    }

    /**
     * @brief permet de recuperer toutes les informations du compte d'un utilisateur
     */
    public function getCompte(string $pseudo) : ?Compte
    {
        $gw = new GatewayListe($this->conn);
        $query = "SELECT * FROM Utilisateur WHERE pseudo=:p";
        if(!$this->conn->executeQuery($query, [":p" => [$pseudo, PDO::PARAM_STR]]))
        {
            return array();
        }
        $comptesSQL = $this->conn->getResults();
        if(sizeof($comptesSQL) != 0)
        {
            $compte = new Compte(
                $comptesSQL[0]["pseudo"],
                $gw->getListeParCreateur(1, 10, $comptesSQL[0]["pseudo"]),
                $comptesSQL[0]["motDePasse"],
            );
            return $compte;
        }
        return null;
    }
}