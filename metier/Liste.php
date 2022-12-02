<?php

class Liste
{
    private $nom;
    private $createur;
    private $id;
    private $taches;


    public function __construct(int $id, string $nom, string $createur, iterable $taches)
    {
        $this->nom = $nom;
        $this->createur = $createur;
        $this->id = $id;
        $this->taches = $taches;
    }

    public function getNom() : string
    {
        return $this->nom;
    }

    public function getCreateur() : string
    {
        return $this->createur;
    }

    public function getId() : int
    {
        return $this->id;
    }
    public function getTaches() : iterable
    {
        return $this->taches;
    }
    public function setTaches(array $taches)
    {
        $this->taches = $taches;
    }
    public function addTache(Tache $t)
    {
        $this->taches[] = $t;
    }

}