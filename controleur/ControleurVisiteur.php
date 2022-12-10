<?php
require_once("config/Validation.php");
require_once("modele/modeleUtilisateur.php");


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
                        $VueErreur[] =	"Erreur d'appel php";
                    require("vues/connexion.php");
                    break;
            }

        }
        catch (PDOException $e)
        {
            //si erreur BD, pas le cas ici
            $VueErreur[] =	"Erreur inattendue!!! ";
            require ($rep.$vues['vues/erreur.php']);

        }
        catch (Exception $e2)
        {
            $VueErreur[] =	"Erreur inattendue!!! ";
            require ($rep.$vues['vues/erreur.php']);
        }
    }

    function Reinit() {
        require("vues/accueil.php");
    }


    function connexion()
    {
        if(!isset($_REQUEST["pseudonyme"]) || !isset($_REQUEST["motDePasse"]))
        {
            throw new Exception("Erreur lors de la transmission des informations de connection");
        }

        $login = Validation::nettoyerString($_REQUEST["pseudonyme"]);
        $mdp = Validation::nettoyerString($_REQUEST["motDePasse"]);

        if(is_null($login) || is_null($mdp))
        {
            throw new ValueError("veuillez entrer votre login ET votre mot de passe ");
        }
        $mdl = new modelUtilisateur();
        $compte = $mdl->connexion($login, $mdp);
        if(!is_null($compte))
        {
            require_once("controleur/ControleurConnecte.php");
            $_REQUEST["action"] = "afficherListe";
            new modelUtilisateur();
        }
        else
        {
            throw new Exception("Erreur lors de la connexion au compte");
        }
    }

    function sInscrire()
    {
        if(!isset($_REQUEST["nom"]))
        {
            throw new Exception("Le pseudonyme doit être renseigné");
        }
        if(empty($_REQUEST["nom"]))
        {
            throw new Exception("Le pseudonyme renseigné est nul");
        }
        if(strlen($_REQUEST["nom"]) < 5)
        {
            throw new Exception("Le pseudonyme doit contenir au minimum 5 caractères");
        }


        if(!isset($_REQUEST["mdp1"]))
        {
            throw new Exception("Le mot de passe n'a pas été envoyé au serveur");
        }
        if(empty($_REQUEST["mdp1"]))
        {
            throw new Exception("Le mot de passe renseigné est nul");
        }
        if(strlen($_REQUEST["mdp1"]) < 8)
        {
            throw new Exception("Le mot de passe doit contenir au minimum 8 caractères");
        }
        if($_REQUEST["mdp1"] != $_REQUEST["mdp2"])
        {
            throw new Exception("Les mots de passes sont différents");
        }

        $pseudo = Validation::nettoyerString($_REQUEST["nom"]);

        if(is_null($pseudo))
        {
            throw new Exception("Le pseudonyme est nul");
        }
        $mdl = new ModeleUtilisateur();
        if(!$mdl->sInscrire($pseudo, $_REQUEST["mdp1"]))
        {
            throw new Exception("Erreur lors de l'inscription");
        }
        $_REQUEST["action"] = "connexion";
        $_REQUEST["pseudonyme"] = $pseudo;
        $_REQUEST["motDePasse"] = $_REQUEST["mdp1"];
        new ControleurVisiteur();
    }

    function supprimerListe()
    {
        $mdl = new ModeleVisiteur();
        if(!isset($_REQUEST["liste"]))
        {
            throw new Exception("La liste doit exister");
        }
        if(empty($_REQUEST["liste"]))
        {
            throw new Exception("La liste doit contenir une valeur");
        }

        if(!Validation::validerIntPossitif($_REQUEST["liste"]))
        {
            throw new Exception("L'ID de la liste doit être positif");
        }
        // TODO: verifier que c'est bien une liste de l'utilisateur
        $mdl->supprimerListe($_REQUEST["liste"]);

        /*
        // Rediréction vers l'accueil
        $_REQUEST["action"] = "seeLists";
        */
        new ControleurVisiteur();
    }

    function delTask()
    {
        $mdl = new ModeleVisiteur();

        // Si la tache est vide, pas set ou <= 0, on lève une exception
        if(!isset($_REQUEST["task"]))
        {
            throw new Exception("Le parametre task doit exister");
        }
        if(empty($_REQUEST["task"]))
        {
            throw new Exception("Le paramètre task doit contenire une valeur");
        }
        if(!Validation::validerUnIntSupperieurZero($_REQUEST["task"]))
        {
            throw new Exception("Le parametre task doit être un entier strictement superieur à 0");
        }

        //TODO: verifier que c'est bien la tache de l'utilisateur.trice

        // Si le numéro de la liste est vide, pas set ou <= 0, on lève une exception
        if(!isset($_REQUEST["list"]))
        {
            throw new Exception("Le parametre list doit exister");
        }
        if(empty($_REQUEST["list"]))
        {
            throw new Exception("Le paramètre list doit contenire une valeur");
        }
        if(!Validation::validerUnIntSupperieurZero($_REQUEST["list"]))
        {
            throw new Exception("Le parametre list doit être un entier strictement superieur à 0");
        }
        //TODO: verifier que c'est bien la list de l'utilisateur.trice et que c'est bien une tache de la liste

        // Suppression de la tache par le modèle
        $mdl->delTask($_REQUEST["task"]);

        //Rediréction vers l'affichage de la liste modifiée
        $_REQUEST["action"] = "seeList";
        new ControleurConnecte();
    }



}