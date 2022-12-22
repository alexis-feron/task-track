<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter une liste de tâches</title>
</head>
<body>
    <?php require("barreNav.php") ?>
    <form method="post" action="?action=ajouteLaListe">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Publique</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="nomNvleListe"></td>
                    <td><input type="checkbox" name="publique"></td>
                </tr>
            </tbody>
        </table>
        <input value="Annuler" type="reset">
        <input value="Ajouter" type="submit">
    </form>
</body>
</html>