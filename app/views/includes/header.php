<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DungeonXplorer</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <header>
            <div id="titleZone">
                <img src="public/img/logo/oslogo.png">
                <p id="titre">Only Stage</p>
            </div>
            <p id="sousTitre">Votre plateforme de recherche de stage!</p>

            <div id="menubar">
                <a class="inputStyle" href="home">Accueil</a>
                <?php 
                if(isset($_SESSION['user_id'])){
                    echo'<a class="inputStyle" href="companies">Entreprises</a>';
                    echo'<a class="inputStyle" href="logoff">Deconnecter</a>';
                }
                else{
                    echo '<a class="inputStyle" href="login">Se connecter</a>';
                }
                 ?>
            </div>
    </header>
    <main>