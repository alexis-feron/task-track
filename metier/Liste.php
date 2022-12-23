<?php

class Liste
{
    private string $nom;
    private string $createur;
    private int $id;
    private iterable $taches;
    private bool $publique;


    public function __construct(int $id, string $nom, string $createur, bool $publique, iterable $taches)
    {
        $this->nom = $nom;
        $this->createur = $createur;
        $this->id = $id;
        $this->taches = $taches;
        $this->publique=$publique;
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
    public function getPublique(): bool
    {
        return $this->publique;
    }
}