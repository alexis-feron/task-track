<?php
class Tache
{
    // Attributs
    private string $nom;
    private bool $faite;
    private int $id;
    private int $listeID;

    // Constructeur
    public function __construct(string $nom, int $tacheID, int $listeID)
    {
        $this->nom = $nom;
        $this->faite = false;
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
        return $this->faite;
    }

    public function setFait(bool $faite)
    {
        $this->faite = $faite;
    }

    public function getId() : int
    {
        return $this->id;
    }
    public function getListeID(): int
    {
        return $this->listeID;
    }
}