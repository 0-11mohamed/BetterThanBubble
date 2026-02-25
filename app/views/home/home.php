<?php include_once(ROOT_DIR . 'app/views/includes/header.php'); ?>

<section id="home">
    <h2>Bienvenue sur OnlyStage !</h2>
    <p>Commencez dès maintenant à chercher l'entreprise pour votre stage !</p>

    <?php 
        if(!isset($_SESSION['user_id'])){ 
            echo'<a class="inputStyle" href="login">Se connecter</a>';
        }
    ?>
</section>

<?php
    if(isset($_SESSION['user_id']) && $_SESSION['typecompte'] == 3){
        echo '<div class="cards-container">
        <div class="card">
            <h3>Entreprises</h3>
            <p>Consultez la liste complète des entreprises disponibles via notre API</p>
            <a href="companies" class="card-button">Voir les entreprises</a>
        </div>
        <div class="card">
            <h3>Stages</h3>
            <p>Recherchez les entreprises où des étudiants ont déjà effectué leur stage</p>
            <a href="stages" class="card-button">Rechercher des stages</a>
        </div>
        <div class="card">
            <h3>Importer mes données</h3>
            <p>Importez un fichier CSV pour ajouter des données dans la base de données</p>
            <a href="import" class="card-button">Importer un fichier</a>
        </div>
    </div>';
    }else if(isset($_SESSION['user_id'])){
        echo '<div class="cards-container">
        <div class="card">
            <h3>Entreprises</h3>
            <p>Consultez la liste complète des entreprises disponibles via notre API</p>
            <a href="companies" class="card-button">Voir les entreprises</a>
        </div>
        <div class="card">
            <h3>Stages</h3>
            <p>Recherchez les entreprises où des étudiants ont déjà effectué leur stage</p>
            <a href="stages" class="card-button">Rechercher des stages</a>
        </div>
    </div>';
    }
?>

<?php include_once(ROOT_DIR . 'app/views/includes/footer.php'); ?>