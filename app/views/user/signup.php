<?php
    $message = $_SESSION['message'] ?? '';
    unset($_SESSION['message']); 
    $root = '/DungeonXplorer';
?>

<?php include_once(ROOT_DIR . 'app/views/includes/header.php'); ?>

<div class="container">
    <h2>Créer un compte</h2>
    <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>
    <form action="register" method="post">
        <div class="form-group">
            <label for="prenom">prenom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div class="form-group">
            <label for="nom">nom :</label>
            <input type="text" id="nom" name="nom" required>
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
    <p>Deja un compte ?</p>
    <a href="login">
        Se connecter
    </a>
</div>

<?php include_once(ROOT_DIR . 'app/views/includes/footer.php'); ?>