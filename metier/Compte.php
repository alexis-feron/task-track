<?php

class Compte
{
    private $pseudonyme;
    private $listes;
    private $motDePasse;

    public function __construct(string $nom,  iterable $listes, string $motDePasse)
    {
        $this->pseudonyme = $nom;
        if(!isset($listes)){
            $this->listes = array();
        }else {
            $this->listes = $listes;
        }
        $this->motDePasse = $motDePasse;
    }

    public function getPseudonyme() : string
    {
        return $this->pseudonyme;
    }

    public function setPseudonyme(string $nvPseudo) : void
    {
        if(!empty($nvPseudo))
        {
            $this->pseudonyme = $nvPseudo;
        }
    }
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    public function getListes()
    {
        return $this->listes;
    }
    public function setListe(iterable $listes)
    {
        $this->listes = $listes;
    }

    public function addListe(Liste $l)
    {
        $this->listes[] = $l;
    }
}