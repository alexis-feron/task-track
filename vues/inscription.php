<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription</title>
</head>
<body>
    <?php require("barreNav.php") ?>
    <form method="post" action="">
        <table>
            <tr>
                <th>Email</th>
                <td><input type="email"></td>
            </tr>
            <tr>
                <th>Mot de passe</th>
                <td><input type="password"></td>
            </tr>
        </table>
        <input value="Annuler" type="reset">
        <input value="S'inscrire" type="submit">
    </form>
</body>
</html>