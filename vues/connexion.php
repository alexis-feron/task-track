<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion</title>
</head>
<body>
    <?php require("barreNav.php") ?>
    <form method="post" action="?action=connexionEnCours">
        <table>
            <tr>
                <th>Login</th>
                <td><input type="text" name="pseudonyme"></td>
            </tr>
            <tr>
                <th>Mot de passe</th>
                <td><input type="password" name="motDePasse"></td>
            </tr>
        </table>
        <input value="Annuler" type="reset">
        <input type="submit" id="submit" name="veutSeConnecter" value="Valider">
    </form>
</body>
</html>