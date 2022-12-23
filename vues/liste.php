<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style/table.css" rel="stylesheet">
    <title>ToDo List</title>
</head>
<body>
    <?php require("barreNav.php") ?>
    <br>
    <input onclick="location.href='?action=ajouterTache'" type="button" value="Ajouter Tache">
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
                <th><?= $tache->nom ?></th>
                <th><?php if($tache->faite==1) echo 'oui'; else echo 'non'?></th>
                <th>
                    <input onclick="location.href='?action=afficherTaches&tache=<?=$tache->id?>'" type="button" value="Tache Faite">
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
