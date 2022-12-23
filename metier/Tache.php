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

}