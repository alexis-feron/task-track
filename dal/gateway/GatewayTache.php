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

    public function modifier(int $id,string $nvnom)
    {
        $query = "UPDATE Tache SET nom = :n WHERE id = :i";
        return $this->conn->executeQuery($query,array(
            ':n' => array($nvnom, PDO::PARAM_STR),
            ':i' => array($id, PDO::PARAM_BOOL)));
    }

    public function supprimer(int $id)
    {
        $query = "DELETE FROM Tache WHERE id =:id";
        return $this->conn->executeQuery($query,array(
            ':id' => array($id, PDO::PARAM_INT)));
    }

    public function getTacheTrie(int $l, int $page, int $nbTache) : iterable //renvoie les taches de l trié par nom
    {
        $query = "SELECT * FROM Tache WHERE idListe=:i LIMIT :p, :n";
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
                $tache["Id"],
                $tache["Nom"],
                $tache["idListe"]
            );
        }
        return $taches;
    }

    public function getTache(int $id)
    {
        $query = "SELECT * FROM Tache WHERE idListe=:i";
        if(!$this->conn->executeQuery($query,array(
            ":i" => array($id, PDO::PARAM_INT))))
        {
            return array();
        }
        $res = $this->conn->getResults();
        return $res;
    }

    public function getNbTacheParListeID(int $idListe): int
    {
        $requette = "SELECT COUNT(*) FROM Tache WHERE idListe = :id";
        if(!$this->conn->executeQuery($requette, array(":id"=>[$idListe, PDO::PARAM_INT])))
        {
            throw new Exception("Problème lors de la récupération des taches");
        }
        return $this->conn->getResults()[0][0];

    }

}
