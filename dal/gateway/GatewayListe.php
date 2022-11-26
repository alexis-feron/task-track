<?php

class GatewayListe
{
    //constructeur

    private $conn;

    public function __construct($conn)
    {
        $this -> conn = $conn;
    }

    public function inserer(ToDOList $l) : bool
    {
        $query = "INSERT INTO List VALUES (:i, :cre, :pu, :li, :n)";
        return $this -> conn->executeQuery($query, array(
            ':i' => array($l->getListId(),PDO::PARAM_INT),
            ':cre'=> array($l->getNomPersonne(),PDO::PARAM_STR),
            ':pu'=> array($l->getPublic(),PDO::PARAM_STR),
            ':li' =>array($l->getTache(),PDO::PARAM_INT),
            ':n'=> array($l->getNomListe()),PDO::PARAM_STR));
    }

    public function supprimer(int $listeId) : bool
    {
        $query = "DELETE FROM List where listeId =:i ";
        return $this -> conn->executeQuery($query, array(
                ':i' => array($listeId,PDO::PARAM_INT)));
    }

    public function modifier(ToDOList $l) : bool
    {
        $query = "UPDATE toDoList SET nom=:n WHERE listeId =:i";
        return $this->conn->executeQuery($query, array(
            ":n" => array($l->getNom(), PDO::PARAM_STR),
            ":i" => array($l->getListId(), PDO::PARAM_INT)));
    }


}