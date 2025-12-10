<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>
<section>

    <h2>Profil</h2>

    <div>
        <h3>Vos informations:</h3>
        <p><?= htmlspecialchars($_SESSION['pseudo']); ?></p>
        <p><?= htmlspecialchars($_SESSION['email']); ?></p>
    </div>

</section>
<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>