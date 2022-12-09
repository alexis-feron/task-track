<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ToDo List</title>
</head>
<body>
    <?php require("barreNav.php") ?>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Faite</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($taches as $tache):?>
            <tr>
                <th><?= $tache->getNom?></th>
                <th><?= $tache->getFaite?></th>
                <th><a href="?action=modifierTache"></th>
                <th><a href="?action=supprimerTache"></th>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</body>
</html>
