<?php
class Tache
{
    // Attributs
    private $nom;
    private $faite;
    private $id;
    private $listeID;

    // Constructeur
    public function __construct(string $nom, int $tacheID, int $listeID)
    {
        $this->nom = $nom;
        $this->fait = false;
        $this->id = $tacheID;
        $this->listeID = $listeID;
    }

    // Accesseurs / Mutatteurs
    public function getNom() : string
    {
        return $this->nom;
    }

    public function setNom(string $nouveauNom)
    {
        $this->nom = $nouveauNom;
    }

    public function estFait() : bool
    {
        return $this->fait;
    }

    public function setFait(bool $fait)
    {
        $this->fait = $fait;
    }

    public function getId() : int
    {
        return $this->id;
    }
    public function getListeID()
    {
        return $this->listeID;
    }
}