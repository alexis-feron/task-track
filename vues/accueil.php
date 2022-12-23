<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style/table.css" rel="stylesheet">
    <title>Accueil</title>
</head>
<body>
    <?php require("barreNav.php") ?>
    <br><input onclick="location.href='?action=ajoutListe'" type="button" value="Ajouter une liste de tâches">
    <br><p>Voici la liste de toutes les listes de taches :</p>
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
                        <th><?php if($l->publique==1) echo 'oui'; else echo 'non'?></th>
                        <th>
                            <input onclick="location.href='?action=afficherTaches&liste=<?=$l->id?>'" type="button" value="Afficher les taches">
                            <input onclick="location.href='?action=modifierListe&liste=<?=$l->id?>'" type="button" value="Modifier le nom">
                            <input onclick="deleteL(<?=$l->id?>)" type="button" value="Supprimer la liste">
                            <script>
                                function deleteL(num){
                                    let valid = confirm("Suppprimer la liste ?");
                                    if(valid===true){
                                        location.href='?action=supprimerListe&liste='+num;
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