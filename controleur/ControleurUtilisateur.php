<?php
require("controleur/ControleurVisiteur.php");
class ControleurUtilisateur extends ControleurVisiteur
{
    function __construct()
    {
        try {
            $action = $_REQUEST['action']; //modif action
            Valider::nettoyerAction(); //à completer
            switch ($action) {
                case NULL:
                    $this->Reinit();
                    break;
                case 'deconnexion':
                    $this->deconnexion();
                    break;
                default:
                    throw new Exception("Action inconnue");
                    break;

            }
        } catch (Exception $e) {
            require("vues/erreur.php");
        }
    }

    function deconnexion()
    {
        $mdl = new ModeleUtilisateur();

        // Destruction de la séssion par le modèle
        $mdl->deconnexion();

        // Rediréction vers la page de connection
        new ControleurVisiteur();

    }
}
