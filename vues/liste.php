<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style/table.css" rel="stylesheet">
    <title>ToDo List</title>
</head>
<body>
    <?php require("barreNav.php") ?>
    <br><input onclick="location.href='?action=ajouterTache&liste=<?= $_REQUEST["liste"]?>'" type="button" value="Ajouter Tache">
    <br><p>Voici la liste de toutes les taches de la liste :</p>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Faite</th>
                <th>Edition</th>
            </tr>
        </thead>
        <tbody>
        <?php if(isset($taches)) :
        foreach($taches as $tache):
            $tache=(object) $tache;?>
            <tr>
                <?php if($tache->faite==1): ?>
                    <th style='text-decoration: line-through'><?= $tache->nom ?></th>
                <?php else: ?>
                    <th><?= $tache->nom ?></th>
                <?php endif; ?>
                <th><?php if($tache->faite==1) echo 'oui'; else echo 'non'?></th>
                <th>
                    <input onclick="location.href='?action=tacheFaite&tache=<?=$tache->id?>'" type="button" value="Tache Faite">
                    <input onclick="location.href='?action=modifierTache&tache=<?=$tache->id?>'" type="button" value="Modifier Nom">
                    <input onclick="deleteT(<?=$tache->id?>)" type="button" value="Supprimer Tache">
                    <script>
                        function deleteT(num){
                            let valid = confirm("Suppprimer la tache ?");
                            if(valid===true){
                                location.href='?action=supprimerTache&tache='+num;
                            }
                        }
                    </script>
                </th>
            </tr>
        <?php endforeach;?>
        <?php endif;?>
        </tbody>
    </table>
</body>
</html>
