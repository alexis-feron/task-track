<?php

class GatewayTache
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function inserer(string $nom, int $listeId) : bool
    {
        $query = "INSERT INTO tache(nom, faite, listeId) VALUES( :n, :f, :i)";

        return $this->conn->executeQuery($query, array(
            ':n' => array($nom, PDO::PARAM_STR),
            ':f'=> array(false, PDO::PARAM_BOOL),
            ':i' => array($listeId, PDO::PARAM_INT)));
    }

    public function modifier(Tache $tacheAModifier)
    {
        $query = "UPDATE tache SET nom = :n, faite = :f WHERE id = :i";
        return $this->conn->executeQuery($query,array(
            ':n' => array($tacheAModifier->getNom(), PDO::PARAM_STR),
            ':fait' => array($tacheAModifier->estFait(), PDO::PARAM_BOOL)));
    }

    public function supprimer(int $id)
    {
        $query = "DELETE FROM tache WHERE tacheId =:id";
        return $this->conn->executeQuery($query,array(
            ':id' => array($id, PDO::PARAM_INT)));
    }


}
