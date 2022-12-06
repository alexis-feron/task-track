<?php

require_once("metier/Tache.php");

class GatewayTache
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function inserer(string $nom, int $listeId) : bool
    {
        $query = "INSERT INTO Tache(nom, faite, listeId) VALUES( :n, :f, :i)";

        return $this->conn->executeQuery($query, array(
            ':n' => array($nom, PDO::PARAM_STR),
            ':f'=> array(false, PDO::PARAM_BOOL),
            ':i' => array($listeId, PDO::PARAM_INT)));
    }

    public function modifier(Tache $tacheAModifier)
    {
        $query = "UPDATE Tache SET nom = :n, faite = :f WHERE id = :i";
        return $this->conn->executeQuery($query,array(
            ':n' => array($tacheAModifier->getNom(), PDO::PARAM_STR),
            ':fait' => array($tacheAModifier->estFait(), PDO::PARAM_BOOL)));
    }

    public function supprimer(int $id)
    {
        $query = "DELETE FROM Tache WHERE tacheId =:id";
        return $this->conn->executeQuery($query,array(
            ':id' => array($id, PDO::PARAM_INT)));
    }

    public function getTache(int $l, int $page, int $nbTache) : iterable
    {
        $query = "SELECT * FROM Tache WHERE listId =:i ORDER BY DateCreation DESC LIMIT :p, :n";
        if(!$this->conn->executeQuery($query,array(
            ":i" => array($l, PDO::PARAM_INT),
            ":p" => array(($page-1)*$nbTache, PDO::PARAM_INT),
            ":n" => array($nbTache, PDO::PARAM_INT))))
        {
            return array();
        }

        $res = $this->conn->getResults();
        $taches = array();
        foreach($res as $tache)
        {
            $taches[] = new Tache(
                $tache["NomTache"],
                $tache["TacheFaite"],
                $tache["Commentaire"],
                $tache["tacheID"],
                $tache["DateCreation"],
                $tache["listID"]
            );
        }
        return $taches;
    }


}
