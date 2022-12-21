<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style/table.css" rel="stylesheet">
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
                <th>Edition</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(isset($listes)) :
                foreach($listes as $l):
                    $l=(object) $l;?>
                    <tr>
                        <th><?= $l->nom?></th>
                        <th><?= $l->createur?></th>
                        <th><?= $l->publique?></th>
                        <th>
                            <input onclick="location.href='?action=modifierListe" type="button" value="Modifier">
                            <input onclick="location.href='?action=supprimerListe'" type="button" value="Supprimer">
                        </th>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
        </tbody>
    </table>
</body>
</html>