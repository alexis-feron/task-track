<?php

//gen
$rep=__DIR__.'/../';

// liste des modules à inclure
$dConfig['includes']= array('controleur/Validation.php');

//BD
$dsn="mysql:host=londres.uca.local;dbname=dbalferon";
$login="alferon";
$mdp="achanger";

//Vues
$vues['erreur']='vues/erreur.php';
$vues['ajoutListe']='vues/ajoutListe.php';
$vues['ajoutTache']='vues/ajoutTache.php';
$vues['connexion']='vues/connexion.php';
$vues['inscription']='vues/inscription.php';
$vues['accueil']='vues/accueil.php';

?>