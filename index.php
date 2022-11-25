<!DOCTYPE html>
<html>
    <?php
        require_once("front-controler/FrontControler.php");
        $frontControler = new FrontControler();
        $controler = $frontControler->start();
        /*<?php
            //si controller pas objet
            //  header('Location: controller/controller.php');
            //si controller objet
            //chargement config
            require_once(__DIR__.'/config/config.php');
            //chargement autoloader pour autochargement des classes
            require_once(__DIR__.'/config/Autoload.php');
            Autoload::charger();
            $cont = new Controleur();
        ?> */
    ?>
</html>
