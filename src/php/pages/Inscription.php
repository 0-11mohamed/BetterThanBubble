<?php
session_start();
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']); // on vide le message après affichage
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="compte">
    <div class="container">
        <h2>Créer un compte</h2>
        <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>
        <form action="Inscrire.php" method="post">
            <div class="form-group">
                <label for="pseudo">Pseudo :</label>
                <input type="text" id="pseudo" name="pseudo" required>
            </div>
            <div class="form-group">
                <label for="email">Adresse e-mail* :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe* :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <p>* obligatoire</p>
            <button type="submit" class="submit-btn">Créer un compte</button>
        </form>
    </div>
</body>
</html>
