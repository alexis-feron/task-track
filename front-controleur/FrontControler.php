<?php
require("config/Validation.php");
require("controleur/ControleurUtilisateur.php");
require("controleur/ControleurVisiteur.php");
require("modele/modeleUtilisateur.php");
require("modele/modeleVisiteur.php");
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
        if(in_array($act,$action['Utilisateur'])) {
            if ($utilisateur == null) {
                require("vues/connexion.php");
            } else{
                $controleur=new ControleurUtilisateur();
            }
        }else{
            $controleur=new ControleurVisiteur();
        }
        $_REQUEST["action"] = "afficherListePub";
        require("vues/accueil.php");
    }
}
