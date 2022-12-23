<?php

    /** Liste des modules à inclure */
    $dConfig['includes']=array('controleur/Validation.php');

    /** Variables pour la connexion à la base de données */
    global $dsn;
    global $login;
    global $mdp;
    $dsn="mysql:host=londres.uca.local;dbname=dbalferon";
    $login ="alferon";
    $mdp="achanger";

    /** Différentes vues */
    $vues['accueil']='vues/accueil.php';
    $vues['ajoutListe']='vues/ajoutListe.php';
    $vues['ajoutTache']='vues/ajoutTache.php';
    $vues['connexion']='vues/connexion.php';
    $vues['erreur']='vues/erreur.php';
    $vues['inscription']='vues/inscription.php';
    $vues['liste']='vues/liste.php';
    $vues['modifierListe']='vues/modifierListe.php';
    $vues['modifierTache']='vues/modifierTache.php';