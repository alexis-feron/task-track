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
    public function creerCompte(string $pseudo, string $email, string $mdp) : bool
    {
        //requette preparée pour eviter les injections sql
        $query = "INSERT INTO Utilisateur(email, pseudo, motDePasse) VALUES(:e,:p, :m)";
        return $this->conn->executeQuery($query, array(
            ":e" => array($email, PDO::PARAM_STR),
            ":p" => array($pseudo, PDO::PARAM_STR),
            ":m" => array($mdp, PDO::PARAM_STR)));
    }

    /**
     * @brief permet de recuperer toutes les informations du compte d'un utilisateur
     */
    public function getCompte(string $pseudo) : ?Compte
    {
        //requette preparée pour eviter les injections sql
        $gw = new GatewayListe($this->conn);
        $query = "SELECT * FROM Utilisateur WHERE pseudo=:p";
        if(!$this->conn->executeQuery($query, [":p" => [$pseudo, PDO::PARAM_STR]]))
        {
            return array();
        }
        $comptesSQL = $this->conn->getResults();
        if(sizeof($comptesSQL) != 0)
        {
            return new Compte(
                $comptesSQL[0]["pseudo"],
                $gw->getListeParCreateur(1, 10, $comptesSQL[0]["pseudo"]),
                $comptesSQL[0]["motDePasse"],
            );
        }
        return null;
    }
}