<?php
require("config/Validation.php");
require("controleur/ControleurUtilisateur.php");
require("controleur/ControleurVisiteur.php");
require("modele/modeleUtilisateur.php");
require("modele/modeleVisiteur.php");
require("config/config.php");

class FrontControler{
    public function start(){
        $actions = array(
            "Utilisateur" => [
                "deconnexion"
            ],
            "Visiteur" => [
                "seConnecter", /*"sInscrire",*/ "accueil",
                "ajoutListe", "modifierListe", "afficherListe", "supprimerListe",
                "supprimerTache", "modifierTache", "ajouterTache","tacheFaite"
            ]
        );
        session_start();
        $action = Validation::nettoyerString(isset($_GET["action"]) ? $_GET["action"] : "");
        $utilisateur=modeleUtilisateur::estConnecte();
        if(in_array($action,$actions['Utilisateur'])) {
            if ($utilisateur == null) {
                require("vues/connexion.php");
            } else{
                $controleur=new ControleurUtilisateur();
            }
        }else{
            $controleur=new ControleurVisiteur();
        }
        $_REQUEST["action"] = "afficherListePub";
        /*require("vues/accueil.php");*/
    }
}
