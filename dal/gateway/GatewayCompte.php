<?php

class GatewayCompte
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    public function CreerCompte(string $pseudo, string $mdp) : bool
    {
        $query = "INSERT INTO compte(pseudonyme, motDePasse) VALUSES(:p, :m)";
        return $this->conn->executeQuerry($query, array(
            ":p" => array($pseudo->getPseudonyme(), PDO::PARAM_STR),
            ":m" => array($mdp->getMotDePasse(), PDO::PARAM_STR)));
    }

    public function modifier(Compte $compteModif)
    {
        $query = "UPDATE compte SET pseudonyme=:p, motDePasse=:m";
        return $this->conn->executeQuerry($query, array(
            ":p" => array($compteModif->getPseudonyme(), PDO::PARAM_STR),
            ":m" => array($compteModif->getMotDePasse(), PDO::PARAM_STR)));

    }

    public function getCompte(string $pseudo) : ?Compte
    {
        $gw = new ListeGateway($this->conn);
        $query = "SELECT * FROM compte WHERE pseudonyme =:p";
        if(!$this->conn->executeQuery($query, [":p" => [$pseudo, PDO::PARAM_STR]]))
        {
            return array();
        }
        $comptesSQL = $this->conn->getResults();
        if(sizeof($comptesSQL) != 0)
        {
            $compte = new Compte(
                $comptesSQL[0]["pseudonyme"],
                $gw->getListeParCreateur(1, 10, $comptesSQL[0]["pseudonyme"]),
                $comptesSQL[0]["motDePasse"],
            );
            return $compte;
        }
        return null;
    }
}