<!DOCTYPE html>
<html>
    <?php
        require_once("front-controler/FrontControler.php");
        $frontControler = new FrontControler();
        $controler = $frontControler->start();
    ?>
</html>
