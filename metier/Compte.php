<?php

class Compte
{
    private $pseudonyme;
    private $listes;
    private $motDePasse;


    public function __construct(string $nom,  iterable $listes = array(), string $motDePasse)
    {
        $this->pseudonyme = $nom;
        $this->listes = $listes;
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

    public function addListe(TodoList $l)
    {
        $this->listes[] = $l;
    }


}