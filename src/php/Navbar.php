<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar">
    <ul class="nav-links">

        <li class="nav-left">
            <a href="../../index.php">OnlyStage</a>
        </li>

        <li class="nav-right">
            <?php if (isset($_SESSION['is_logged_in'])): ?>
                <span>Bienvenue <?= htmlspecialchars($_SESSION['prenom']) ?></span>
                <a href="pages/Deconnecter.php">Se Déconnecter</a>
            <?php else: ?>
                <a href="pages/Inscription.php">S'inscrire</a>
                <a href="pages/seConnecter.php">Se Connecter</a>
            <?php endif; ?>
        </li>

    </ul>
</nav>
