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
    //ajoute liste ds la BD
    /*public function inserer(Liste $l): bool
    {
        $query = "INSERT INTO Liste VALUES (:i, :cre, :pu, :n)";
        return $this->conn->executeQuery($query, array(
            ':i' => array($l->getId(), PDO::PARAM_INT),
            ':cre' => array($l->getCreateur(), PDO::PARAM_STR),
            ':pu' => array($l->getPublique(), PDO::PARAM_STR),
            ':n' => array($l->getNom()), PDO::PARAM_STR));
    }
    */

    public function inserer(Liste $liste): bool
    {
        $query = "INSERT INTO Liste(id,nom,createur,publique) VALUES(:i, :n, :cre, :pu)";
        return $this->conn->executeQuery($query, array(
            ':i' => array($liste->getId(), PDO::PARAM_INT),
            ':cre' => array($liste->getCreateur(), PDO::PARAM_STR),
            ':pu' => array($liste->getPublique(), PDO::PARAM_BOOL),
            ':n' => array($liste->getNom(), PDO::PARAM_STR),
        ));
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
        $query = "SELECT * FROM Liste WHERE id = :i";
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
            $liste["publique"],
            $gwTache->getTacheTrie($liste["id"], 1, 10)
        );
    }

    public function getListes(): array
    {
        $gw=new GatewayTache($this->conn);
        $query = "SELECT * FROM Liste WHERE publique=true";
        $isOK = $this->conn->executeQuery($query, array());
        if (!$isOK) {
            throw new Exception("Erreur lors de la récupération des listes");
        }
        $listes = $this->conn->getResults();
        if (sizeof($listes) == 0) {
            throw new Exception("Aucune liste trouvée");
        }
        return $listes;
    }
    public function getListesPriv(): array
    {
        $gw=new GatewayTache($this->conn);
        $query = "SELECT * FROM Liste WHERE createur=:c AND publique=false";
        $isOK = $this->conn->executeQuery($query, array(
            ":c" => array($_SESSION["login"], PDO::PARAM_STR)
        ));
        if (!$isOK) {
            throw new Exception("Erreur lors de la récupération des listes");
        }
        $listes = $this->conn->getResults();
        $listesPub=$this->getListes();
        foreach ($listesPub as $l) {
            $listes[] = $l;
        }
        if (sizeof($listes) == 0) {
            throw new Exception("Aucune liste trouvée");
        }
        return $listes;
    }


    public function getListeParCreateur(int $page, int $nbListes, string $createur) : iterable
    {
        $gwTache = new GatewayTache($this->conn);
        $listes = array();
        $requete = "SELECT * FROM Liste WHERE createur = :c  LIMIT :p, :n";
        $isOK=$this->conn->executeQuery($requete, [
            ":c" => [$createur, PDO::PARAM_STR],
            ":p" => [($page-1)*$nbListes, PDO::PARAM_INT],
            ":n" => [$nbListes, PDO::PARAM_INT]
        ]);
        if(!$isOK)
        {
            return array();
        }

        $res = $this->conn->getResults();
        $listes = array();
        foreach($res as $liste)
        {
            $listes[] = new Liste(
                $liste["id"],
                $liste["nom"],
                $liste["createur"],
                false,
                $gwTache->getTache($liste["id"])
            );
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