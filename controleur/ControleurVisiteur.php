<?php

class ControleurVisiteur
{
    function __construct()
    {
        global $rep,$vues; // nécessaire pour utiliser variables globales

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
                case 'sInscrire':
                    $this->sInscrire();
                    break;
                case 'ajoutListe':
                    $this->ajoutListe();
                    break;
                case 'modifierListe':
                    $this->modifierListe();
                    break;
                case 'afficherListe':
                    $this->afficherListe();
                    break;
                case 'supprimerListe':
                    $this->supprimerListe();
                    break;
                case 'supprimerTache':
                    $this->supprimerTache();
                    break;
                case 'modifierTache':
                    $this->modifierTache();
                    break;
                case 'ajouterTache':
                    $this->ajouterTache();
                    break;
                case 'tacheFaite':
                    $this->tacheFaite();
                    break;
                case 'seConnecter':
                    default:
                    $dVueEreur[] =	"Erreur d'appel php";
                    require("vues/connexion.php");
                    break;
            }

        }
        catch (PDOException $e)
        {
            //si erreur BD, pas le cas ici
            $dVueEreur[] =	"Erreur inattendue!!! ";
            require ($rep.$vues['erreur']);

        }
        catch (Exception $e2)
        {
            $dVueEreur[] =	"Erreur inattendue!!! ";
            require ($rep.$vues['erreur']);
        }
    }

}