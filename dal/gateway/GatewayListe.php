<?php

require_once("dal/gateway/GatewayTache.php");
require_once("metier/Tache.php");
require_once("metier/Liste.php");

class GatewayListe
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function inserer(Liste $l): bool
    {
        $query = "INSERT INTO Liste VALUES (:i, :cre, :pu, :n)";
        return $this->conn->executeQuery($query, array(
            ':i' => array($l->getId(), PDO::PARAM_INT),
            ':cre' => array($l->getCreateur(), PDO::PARAM_STR),
            ':pu' => array($l->getPublique(), PDO::PARAM_STR),
            ':n' => array($l->getNom()), PDO::PARAM_STR));
    }

    public function inserer2(string $nom, string $createur) : bool
    {
        $requette = "INSERT INTO Liste (nom, createur) VALUES(:n, :c)";
        return $this->conn->executeQuery($requette, [
            ":n" => [$nom, PDO::PARAM_STR],
            ":c" => [$createur, PDO::PARAM_STR]
        ]);

    }


    public function supprimer(int $listeId): bool
    {
        $query = "DELETE FROM Liste where id =:i ";
        return $this->conn->executeQuery($query, array(
            ':i' => array($listeId, PDO::PARAM_INT)));
    }

    public function modifier(int $id, string $nom) : bool
	{
        $query = "UPDATE Liste SET nom=:n WHERE id=:id";
        return $this->conn->executeQuery($query, array(
            ":n" => array($nom, PDO::PARAM_STR),
            ":id" => array($id, PDO::PARAM_INT)));
    }

    public function getListeParNom(int $page, int $nbListes) : array
    {
        $gwTache = new GatewayTache($this->conn);
        $lites = array();
        $requete = "SELECT * FROM Liste ORDER BY nom  LIMIT :p+:nb, :nb";
        $isOK=$this->conn->executeQuery($requete, array(
            ":p" => array($page-1, PDO::PARAM_INT),
            ":nb" => array($nbListes, PDO::PARAM_INT)));
        if(!$isOK)
        {
            return array();
        }

        $res = $this->conn->getResults();

        foreach($res as $liste)
        {
            $listes[] = new Liste(
                $liste["id"],
                $liste["nom"],
                $liste["createur"],
                $liste["publique"],
                $gwTache->getTacheTrie($liste["listeID"], 1, 10));
        }
        return $listes;
    }

    public function Actualiser(Liste $l, int $page, int $nbTaches): Liste
    {
        $gwTache = new GatewayTache($this->conn);
        $l->setTaches($gwTache->getTache($l->getId()));
        return $l;
    }

    public function getListe(int $id): Liste
    {
        $gwTache = new GatewayTache($this->conn);
        $query = "SELECT * FROM List WHERE id = :i";
        $isOK = $this->conn->executeQuery($query, array(
            ":i" => array($id, PDO::PARAM_INT)));
        if (!$isOK) {
            throw new Exception("Erreur lors de la récupération de la liste numéro $id");
        }
        $liste = $this->conn->getResults();
        if (sizeof($liste) == 0) {
            throw new Exception("La liste n°$id n'a pas été trouvée ou n'existe pas");
        }
        $liste = $liste[0];
        return new Liste(
            $liste["id"],
            $liste["nom"],
            $liste["createur"],
            $liste["punlique"],
            $gwTache->getTacheTrie($liste["listeID"], 1, 10)
        );
    }
    public function getListeParCreateur(int $page, int $nbListes, Compte $compte) : array
    {
        $gwTache = new GatewayTache($this->conn);
        $listes = array();
        $requete = "SELECT * FROM Liste ORDER BY nom LIMIT :p+:nb, :nb";
        $isOK=$this->conn->executeQuery($requete, array(
            ":p" => array($page-1, PDO::PARAM_INT),
            ":nb" => array($nbListes, PDO::PARAM_INT)));
        if(!$isOK)
        {
            return array();
        }
        $res = $this->conn->getResults();
        foreach($res as $liste)
        {
            $listes[] = new Liste(
                $liste["id"],
                $liste["nom"],
                $liste["createur"],
                $liste["publique"],
                $gwTache->getTacheTrie($liste["id"], 1, 10));
        }
        return $listes;
    }

    public function getNbListesParCreateur(string $createur): int
    {
        $requette = "SELECT COUNT(*) FROM Liste WHERE Createur = :c";
        if(!$this->conn->executeQuery($requette, array(":c"=>[$createur, PDO::PARAM_STR])))
        {
            throw new Exception("Problème lors de la récupération des listes");
        }
        return $this->conn->getResults()[0][0];

    }

}