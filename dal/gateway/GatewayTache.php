<?php

require("metier/Tache.php");
require("metier/Liste.php");

class GatewayTache
{
    private $conn;

    public function __construct(Connexion $conn)
    {
        $this->conn = $conn;
    }

    public function inserer(int $id, string $nom, int $idListe) : bool
    {
        $query = "INSERT INTO Tache(id, nom, faite, idListe) VALUES(:i, :n, :f, :l)";

        return $this->conn->executeQuery($query, array(
            ':i' => array($id, PDO::PARAM_INT),
            ':n' => array($nom, PDO::PARAM_STR),
            ':f'=> array(false, PDO::PARAM_BOOL),
            ':l' => array($idListe, PDO::PARAM_INT)));
    }

    public function tacheFaite(int $id) : bool
    {
        $query = "UPDATE Tache SET faite=!faite WHERE id = :i";

        return $this->conn->executeQuery($query, array(
            ':i' => array($id, PDO::PARAM_INT)));
    }

    public function modifier(int $id,string $nvnom): bool
    {
        $query = "UPDATE Tache SET nom = :n WHERE id = :i";
        return $this->conn->executeQuery($query,array(
            ':n' => array($nvnom, PDO::PARAM_STR),
            ':i' => array($id, PDO::PARAM_BOOL)));
    }

    public function supprimer(int $id): bool
    {
        $query = "DELETE FROM Tache WHERE id =:id";
        return $this->conn->executeQuery($query,array(
            ':id' => array($id, PDO::PARAM_INT)));
    }

    public function getTache(int $id): array
    {
        $query = "SELECT * FROM Tache WHERE idListe=:i";
        if(!$this->conn->executeQuery($query,array(
            ":i" => array($id, PDO::PARAM_INT))))
        {
            return array();
        }
        return $this->conn->getResults();
    }


}
