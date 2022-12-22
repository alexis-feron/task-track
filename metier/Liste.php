<?php

class Liste
{
    private $nom;
    private $createur;
    private $id;
    private $taches;
    private $publique;


    public function __construct(int $id, string $nom, string $createur,bool $publique, iterable $taches)
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
    public function getPublique()
    {
        return $this->publique;
    }
    public function genererId()
    {
        return $nvlId = abs(crc32(uniqid())); //creer id unique sous forme de chaine de caractere(uniqid) puis remis en hexa et
        // encode sur 32 bits(8 caracteres par crc32)puis prends val absolue pr positif(abs)
    }
}