<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceuil</title>
</head>
<body>
    <?php require("barreNav.php") ?>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Créateur</th>
                <th>Publique</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($listes)) :
                foreach($listes as $l):
                    $l=(object) $l;?>
                    <tr>
                        <th><?= $l->nom?></th>
                        <th><?= $l->createur?></th>
                        <th><?= $l->publique?></th>
                        <th><input value="Modifier" type="button"></th>
                        <th><input value="Supprimer" type="button"></th>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
        </tbody>
    </table>
</body>
</html>