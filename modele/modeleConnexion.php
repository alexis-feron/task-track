<?php

class modeleConnexion{
    public function connection(string $login, string $mdp) : Compte
    {
        // Connection à la basse de données
        global $dsn, $login, $mdp;
        $gw = new CompteGateway(new Connection($dsn, $login, $mdp));

        // Récupère le compte $login
        $compte = $gw->getCompte($login);

        // Si il a pas trouvé le compte $login, c'est qu'il existe pas
        if($compte == null)
        {
            throw new Exception("Login ou mot de passe incorrect");
        }
        // Verification du mdp
        if(!password_verify($mdp, $compte->getMotDePasse()))
        {
            throw new Exception("Login ou mot de passe incorrect");
        }

        $_SESSION["login"] = $compte->getPseudonyme();
        $_SESSION["Lists"] = $compte->getListes();
        return $compte;
    }

}