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
                "seConnecter", /*"sInscrire",*/ "accueil", "connexionEnCours",
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
                echo "<br>ERREUR : Vous n'êtes pas connecté, veuillez vous connecter pour accèder à cette fonctionnalité";
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
