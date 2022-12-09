<?php
require_once("controleur/ControleurUtilisateur.php");
require_once("controleur/ControleurVisiteur.php");
require_once("modeles/modeleUtilisateur.php");
require_once("config/Validation.php");
require("config/config.php");

class FrontControler{
    public function start(){
        $action = array(
            "Utilisateur" => [
                "deconnexion"
            ],
            "Visiteur" => [
                "seConnecter", "sInscrire",
                "ajoutListe", "modifierListe", "afficherListe", "supprimerListe",
                "supprimerTache", "modifierTache", "ajouterTache","tacheFaite"
            ]
        );
        session_start();
        $act = Validation::nettoyerString(isset($_GET["action"]) ? $_GET["action"] : "");
        $utilisateur=modeleUtilisateur::estConnecte();
        $controleur = new ControleurVisiteur();
        if(in_array($action['Utilisateur'],$act)) {
            if ($utilisateur == null) {
                require("vues/connexion.php");
            } else{
                new ControleurUtilisateur();
            }
        }else{
            new ControleurVisiteur();
        }
        $_REQUEST["action"] = "afficherListePub";
        require("vues/accueil.php");
    }
}
