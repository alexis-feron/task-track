<?php

class GatewayListe
{
    //constructeur

    private $conn;

    public function __construct($conn)
    {
        $this -> conn = $conn;
    }

    public function inserer($l) : bool
    {
        $query = "INSERT INTO List VALUES (:i, :cre, :pu, :li, :n)";
        return $this -> conn->executeQuery($query, array(
            ':i' => array($l->getId(),PDO::PARAM_INT),
            ':cre'=> array($l->getNomPersonne(),PDO::PARAM_STR),
            ':pu'=> array($l->getPublic(),PDO::PARAM_STR),
            ':li' =>array($l->getTache(),PDO::PARAM_INT),
            ':n'=> array($l->getNomListe()),PDO::PARAM_STR));
    }

    public function supprimer($l, $id) : bool
    {
        $query = "DELETE :i FROM List";
        return $this -> conn->executeQuery($query, array(
                ':i' => array($id,PDO::PARAM_INT)));
    }

}