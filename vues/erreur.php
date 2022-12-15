<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erreur</title>
</head>
<body>
    <?php require("barreNav.php") ?>
    <h1>Erreur</h1>
    <?php
        if (isset($VueErreur)) {
            foreach ($VueErreur as $value){
                echo $value;
            }
        }
    ?>
</body>
</html>