<?php

class modeleUtilisateur{
    public function estConnecte() : bool
    {
        if(isset($_SESSION["login"]) && !empty($_SESSION["login"]))
        {
            return true;
        }
        return false;
    }

    public function deconnexion()
    {
        session_destroy();
    }
}