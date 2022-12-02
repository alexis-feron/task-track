<?php
require_once("controleur/ControleurUtilisateur.php");
require_once("controleur/ControleurVisiteur.php");
require_once("modeles/modeleConnexion.php");
require_once("config/Validation.php");
require("config/config.php");

class FrontControler{
    private $actions = array(
        "Utilisateur" => [
            "ajoutListePriv", "modifierListePriv", "afficherListePriv", "supprimerListePriv",
            "deconnexion", "supprimerTachePriv", "modifierTachePriv", "modifierTachePriv"
        ],
        "Visiteur" => [
            "seConnecter", "sInscrire", "tacheFaite",
            "ajoutListePub", "modifierListePub", "afficherListePub", "supprimerListePub",
            "supprimerTachePub", "modifierTachePub", "modifierTachePub"
        ]
    );

    public function start(){
        session_start();
        $action = Validation::nettoyerString(isset($_GET["action"]) ? $_GET["action"] : "");
        $controleur = new ControleurVisiteur();
        $_REQUEST["action"] = "afficherListePub";
        require("vues/accueil.php");
    }
}
