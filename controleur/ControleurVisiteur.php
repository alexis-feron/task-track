<?php

class ControleurVisiteur
{
    function __construct()
    {
        global $rep,$vues; // nécessaire pour utiliser variables globales

        try {
            $action = $_REQUEST['action']; //modif action

            Validation::nettoyerAction(); //à completer
            switch ($action) {
                case NULL:
                    $this->Reinit();
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


    function seConnecter()
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
        $mdl = new modelVisiteur();
        $compte = $mdl->seConnecter($login, $mdp);
        if(!is_null($compte))
        {
            require_once("controleur/ControleurConnecte.php");
            $_REQUEST["action"] = "afficherListe";
            new modelVisiteur();
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
        $_REQUEST["action"] = "seConnecter";
        $_REQUEST["pseudonyme"] = $pseudo;
        $_REQUEST["motDePasse"] = $_REQUEST["mdp1"];
        new ControleurVisiteur();
    }


    function ajoutListe()
    {
        if(!isset($_REQUEST["nomNvleListe"]))
        {
            throw new Exception("La nouvelle liste doit avoir un nom!");
        }
        if(empty($_REQUEST["nomNvleListe"]))
        {
            throw new Exception("La liste à creer ne peut pas avoir un nom nul");
        }
        $nom = Validation::nettoyerString($_REQUEST["nomNvleListe"]);

        // test si nettoyage a fonctionné
        if(is_null($nom))
        {
            throw new Exception("Veuillez entrer un nom");
        }
        $mdl = new ModeleVisiteur();

        // Création de la todoList par le modèle.
        $mdl->creerListe($nom);

        //$_REQUEST["action"] = "seeLists";
        new ControleurVisiteur();
    }

    function modifierListe()
    {
        $mdl = new ModeleVisiteur();

        if(!isset($_REQUEST["liste"]))
        {
            throw new Exception("La liste n'existe pas");
        }
        if(empty($_REQUEST["liste"]))
        {
            throw new Exception("La liste ne peut pas être nulr");
        }
        if(!Validation::validerIntPossitif($_REQUEST["liste"]))
        {
            throw new Exception("L'ID de la liste doit être positif");
        }

        if(!isset($_REQUEST["nvNom"]))
        {
            throw new Exception("Le nom doit exister");
        }
        if(empty($_REQUEST["nvNom"]))
        {
            throw new Exception("Le nouveau nom ne peut pas être nul");
        }
        $nouveauNom = Validation::nettoyerString($_REQUEST["nvNom"]);
        if(is_null($nouveauNom))
        {
            throw new Exception("Le nom entré n'est pas correct");
        }

        // Modification du nom de la liste par le modèle
        $mdl->modifierNomListe($_REQUEST["liste"], $nouveauNom);

        /*
        // Rediréction vers l'accueil
        $_REQUEST["action"] = "seeLists";
        */
        new ControleurVisiteur();
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

        $mdl = new modeleUtilisateur();

        $todoLists = $mdl->getListe(Validation::nettoyerString($_SESSION["login"]), $page, $nbElements);

        $maxPage = $mdl->getMaxPageListes(Validation::nettoyerString($_SESSION["login"]), $nbElements);

        require("vues/accueil.php");
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

    function ajouterTache()
    {
        $mdl = new ModeleVisiteur();

        if(!isset($_REQUEST["nomTache"]))
        {
            throw new Exception("La tache n'existe pas");
        }
        if(empty($_REQUEST["nomTache"]))
        {
            throw new Exception("Le nom de la nouvelle tache ne doit pas être vide");
        }

        // Si le commentaire de la tache n'est pas set, on lève une exception
        if(!isset($_REQUEST["commentaireTache"]))
        {
            throw new Exception("Le commentaire de la tache est introuvable!");
        }

        // Si le numéro de la liste est vide ou n'est pas set, on lève une exception
        if(!isset($_REQUEST["list"]))
        {
            throw new Exception("Le numero de liste doit exister");
        }
        if(empty($_REQUEST["list"]))
        {
            throw new Exception("Le numero de liste doit être définit");
        }

        // Validation des paramètres
        $list = Validation::validerIntPossitif($_REQUEST["list"]) ? $_REQUEST["list"] : null;
        $nom = Validation::nettoyerString($_REQUEST["nomTache"]);

        // Verification des paramètre, si il y en a 1 qui vas pas, on lève une exception
        if(is_null($nom) || is_null($list))
        {
            throw new Exception("Le nom, la liste ou le commentaire de la nouvelle tache contiennent des caractèrent illégales!");
        }

        // Création de la tache par le modèle
        $mdl->createTask($nom, $list);

        $_REQUEST["action"] = "seeList";
        $_REQUEST["list"] = $list;
        new ControleurVisiteur();

    }

    function modifierTache()
    {
        $mdl = new ModeleVisiteur();

        if(!isset($_REQUEST["tache"]))
        {
            throw new Exception("Le parametre task doit exister");
        }
        if(empty($_REQUEST["tache"]))
        {
            throw new Exception("Le paramètre task doit contenire une valeur");
        }
        if(!Validation::validerIntPossitif($_REQUEST["tache"]))
        {
            throw new Exception("Le parametre task doit être un entier strictement superieur à 0");
        }

        // Si le numéro de la liste est pas set, vide ou <=0, on lève une exception
        if(!isset($_REQUEST["liste"]))
        {
            throw new Exception("Le parametre list doit exister");
        }
        if(empty($_REQUEST["liste"]))
        {
            throw new Exception("Le paramètre list doit contenire une valeur");
        }
        if(!Validation::validerIntPossitif($_REQUEST["liste"]))
        {
            throw new Exception("Le parametre list doit être un entier strictement superieur à 0");
        }

        // Si le nom est vide ou pas set, on lève une exception
        if(!isset($_REQUEST["nom"]))
        {
            throw new Exception("Le parametre nom doit exister");
        }
        if(empty($_REQUEST["nom"]))
        {
            throw new Exception("Le paramètre nom doit contenire une valeur");
        }


        // Validation des paramètres
        $nom = Validation::nettoyerString($_REQUEST["nom"]);

        // Si un des paramètres est invalide, on lève une exception
        if(is_null($nom))
        {
            throw new Exception("Le nom ou le commentaire contien des valeurs illégales");
        }

        // Modification de la tache par le modèle
        $mdl->modifierNomCommTache($_REQUEST["tache"], $nom);

        // Définition des variables nécessaire à la vue
        $list = $_REQUEST["list"];

        // Rediréction vers l'affichage le la liste list
        $_REQUEST["action"] = "seeList";
        new ControleurVisiteur();
    }


    function supprimerTache()
    {
        $mdl = new ModeleVisiteur();

        // Si la tache est vide, pas set ou <= 0, on lève une exception
        if(!isset($_REQUEST["tache"]))
        {
            throw new Exception("Le parametre task doit exister");
        }
        if(empty($_REQUEST["tache"]))
        {
            throw new Exception("Le paramètre task doit contenire une valeur");
        }
        if(!Validation::validerIntPossitif($_REQUEST["tache"]))
        {
            throw new Exception("Le parametre task doit être un entier strictement superieur à 0");
        }

        //TODO: verifier que c'est bien la tache de l'utilisateur.trice

        if(!isset($_REQUEST["liste"]))
        {
            throw new Exception("La liste doit exister");
        }
        if(empty($_REQUEST["liste"]))
        {
            throw new Exception("La liste doit doit contenir une valeur");
        }
        if(!Validation::validerIntPossitif($_REQUEST["liste"]))
        {
            throw new Exception("L'ID de la liste doit être positif");
        }
        //TODO: verifier que c'est bien la list de l'utilisateur.trice et que c'est bien une tache de la liste

        // Suppression de la tache par le modèle
        $mdl->supprimerTache($_REQUEST["tache"]);

        /*
        //Rediréction vers l'affichage de la liste modifiée
        $_REQUEST["action"] = "seeList";
        */
        new ControleurVisiteur();
    }



}