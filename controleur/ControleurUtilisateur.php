<?php
require_once("config/Validation.php");
require_once("controleur/ControleurVisiteur.php");


class ControleurUtilisateur
{
    function __construct()
    {
        try {
            $action = $_REQUEST['action']; //modif action
            Valider::nettoyerAction(); //à completer
            switch ($action)
            {
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
        }

        function afficherListe()
        {
            if(!isset($_REQUEST["page"]) || empty($_REQUEST["page"]))
            {
                $page = 1;
            }
            else
            {
                $page = Validation::validerIntPossitif($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
            }

            if(!isset($_GET["nbElements"]) || empty($_GET["nbElements"]))
            {
                $nbElements = 10;
            }
            else
            {
                $nbElements = Validation::validerIntPossitif($_GET["nbElements"]) ? $_GET["nbElements"] : 10;
            }

            $mdl = new modelUtilisateur();

            $todoLists = $mdl->getLists(Validation::nettoyerString($_SESSION["login"]), $page, $nbElements);

            $maxPage = $mdl->getMaxPageListes(Validation::nettoyerString($_SESSION["login"]), $nbElements);

            require("vues/accueil.php");
        }






//debut

//on initialise un tableau d'erreur
        $dVueEreur = array ();

        try{
            $action=$_REQUEST['action'];

            switch($action) {

//pas d'action, on r�initialise 1er appel
                case NULL:
                    $this->Reinit();
                    break;


                case "validationFormulaire":
                    $this->ValidationFormulaire($dVueEreur);
                    break;

//mauvaise action
                default:
                    $dVueEreur[] =	"Erreur d'appel php";
                    require ($rep.$vues['vuephp1']);
                    break;
            }

        } catch (PDOException $e)
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


//fin
        exit(0);
    }//fin constructeur


    function Reinit() {
        global $rep,$vues; // nécessaire pour utiliser variables globales

        $dVue = array (
            'nom' => "",
            'age' => 0,
        );
        require ($rep.$vues['vuephp1']);
    }

    function ValidationFormulaire(array $dVueEreur) {
        global $rep,$vues;


//si exception, ca remonte !!!
        $nom=$_POST['txtNom']; // txtNom = nom du champ texte dans le formulaire
        $age=$_POST['txtAge'];
        Validation::val_form($nom,$age,$dVueEreur);

        $model = new Simplemodel();
        $data=$model->get_data();

        $dVue = array (
            'nom' => $nom,
            'age' => $age,
            'data' => $data,
        );
        require ($rep.$vues['vuephp1']);
    }
}
