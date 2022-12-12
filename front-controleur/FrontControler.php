<?php
require("config/Validation.php");
require("controleur/ControleurUtilisateur.php");
require("modele/modeleUtilisateur.php");
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
        $modele = new modeleVisiteur();
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
        $_REQUEST["action"] = "afficherListe";
        /*require("vues/accueil.php");*/
    }
}
