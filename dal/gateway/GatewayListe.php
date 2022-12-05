<?php

// require tache
//require todolist
require_once("dal/gateway/GatewayTache.php");

/*
 supprimerAvecListID -> supprimer
modiferNomListe -> modifer
ActualiserListe -> Actualiser
getListeParID -> getListe
*/
class GatewayListe
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function inserer(ToDOList $l): bool
    {
        $query = "INSERT INTO List VALUES (:i, :cre, :pu, :li, :n)";
        return $this->conn->executeQuery($query, array(
            ':i' => array($l->getListId(), PDO::PARAM_INT),
            ':cre' => array($l->getNomPersonne(), PDO::PARAM_STR),
            ':pu' => array($l->getPublic(), PDO::PARAM_STR),
            ':li' => array($l->getTache(), PDO::PARAM_INT),
            ':n' => array($l->getNomListe()), PDO::PARAM_STR));
    }

    public function supprimer(int $listeId): bool
    {
        $query = "DELETE FROM List where listeId =:i ";
        return $this->conn->executeQuery($query, array(
            ':i' => array($listeId, PDO::PARAM_INT)));
    }

    public function modifier(int $id, string $nom) : bool
	{
        $query = "UPDATE _TodoList SET nom=:n WHERE listeID=:id";
        return $this->conn->executeQuery($query, array(
            ":n" => array($nom, PDO::PARAM_STR),
            ":id" => array($id, PDO::PARAM_INT)));
    }

    public function Actualiser(ToDOList $l, int $page, int $nbTaches): ToDOList
    {
        $gwTache = new GatewayTache($this->conn);
        $l->setTaches($gwTache->getTache($l->getId(), $page, $nbTaches));
        return $l;
    }

    public function getListe(int $id): ToDOList
    {
        $gwTache = new GatewayTache($this->conn);
        $query = "SELECT * FROM _TodoList WHERE listeID = :i";
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
        return new ToDOList(
            $liste["listeID"],
            $liste["nom"],
            $gwTache->getTache($liste["listeID"], 1, 10)
        );
    }




}