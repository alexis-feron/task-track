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
        $query = "INSERT INTO Liste VALUES (:i, :cre, :pu, :li, :n)";
        return $this->conn->executeQuery($query, array(
            ':i' => array($l->getListId(), PDO::PARAM_INT),
            ':cre' => array($l->getNomPersonne(), PDO::PARAM_STR),
            ':pu' => array($l->getPublic(), PDO::PARAM_STR),
            ':li' => array($l->getTache(), PDO::PARAM_INT),
            ':n' => array($l->getNomListe()), PDO::PARAM_STR));
    }

    public function supprimer(int $listeId): bool
    {
        $query = "DELETE FROM Liste where listeId =:i ";
        return $this->conn->executeQuery($query, array(
            ':i' => array($listeId, PDO::PARAM_INT)));
    }

    public function modifier(int $id, string $nom) : bool
	{
        $query = "UPDATE Liste SET nom=:n WHERE listeID=:id";
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
                $liste["listeID"],
                $liste["nom"],
                $liste["Createur"],
                $gwTache->getTachesParIDListe($liste["listeID"], 1, 10));
        }
        return $listes;
    }

    public function Actualiser(Liste $l, int $page, int $nbTaches): Liste
    {
        $gwTache = new GatewayTache($this->conn);
        $l->setTaches($gwTache->getTache($l->getId(), $page, $nbTaches));
        return $l;
    }

    public function getListe(int $id): Liste
    {
        $gwTache = new GatewayTache($this->conn);
        $query = "SELECT * FROM List WHERE listeID = :i";
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
            $liste["listeID"],
            $liste["nom"],
            $gwTache->getTache($liste["listeID"], 1, 10)
        );
    }
}