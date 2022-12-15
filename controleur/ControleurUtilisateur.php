<?php
require("controleur/ControleurVisiteur.php");
class ControleurUtilisateur extends ControleurVisiteur
{
    function __construct()
    {
        parent::__construct();
        try {
            $action = $_REQUEST['action']; //modif action

            Validation::nettoyerAction(); //à completer
            switch ($action) {
                case NULL:
                    $this->Reinit();
                    break;
                case 'deconnexion':
                    $this->deconnexion();
                    break;
                default:
                    throw new Exception("Action inconnue");
            }
        } catch (Exception $e) {
            require("vues/erreur.php");
        }
    }

    function deconnexion()
    {
        $mdl = new ModeleUtilisateur();

        // Destruction de la session par le modele
        $mdl->deconnexion();

        // Redirection vers la page de connection
        new ControleurVisiteur();

    }
}
