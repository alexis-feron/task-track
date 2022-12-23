<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription</title>
</head>
<body>
    <?php require("barreNav.php") ?>
    <form method="post" action="?action=veutInscrire">
        <table>
            <tr>
                <th>Login</th>
                <td><input type="text" name="pseudonyme"></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><input type="email" name="email"></td>
            </tr>
            <tr>
                <th>Mot de passe</th>
                <td><input type="password" name="mdp"></td>
            </tr>
        </table>
        <input value="Annuler" type="reset">
        <input value="S'inscrire" type="submit">
    </form>
</body>
</html>