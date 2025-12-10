<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Recherche Stage</title>
        <meta name="author" content="Mohamed, Milo, Lylian, Clément, Antoinne">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="src/javascript/script.js"></script>
        <link rel="stylesheet" href="src/css/style.css"/>
        <link rel="icon" href="assets/oslogo.png"/>
    </head>
    
    <body class="flex-col">
        <div id="titleZone">
            <img src="./assets/oslogo.png">
            <p id="titre">Only Stage</p>
        </div>
        
        <?php 
        include_once 'src/php/Navbar.php' ;
        ?>

        <p id="sousTitre">Votre plateforme de recherche de stage!</p>

        <div id="menubar">
            <a class="inputStyle">Accueil</a>
            <a class="inputStyle">BDD IUT</a>
            <a class="inputStyle">A propos</a>
        </div>

        <div class="main">
            <div id="searchZone" class="flex-row">
                <select id="filter" class="inputStyle">
                    <option value="nom">Nom d'entreprise</option>
                    <option value="activite">Domaine d'activité</option>
                    <option value="region">Région</option>
                </select>

                <input class="inputStyle" type="search" id="query" placeholder="Rechercher...">
            </div>

            <div class="tailleSearch">
                <p>Taille de l'entreprise :</p>
                <label><input type="radio" name="taille" value="GE"> Grande</label>
                <label><input type="radio" name="taille" value="ETI"> Intermédiaire</label>
                <label><input type="radio" name="taille" value="MPE"> Petite</label>
            </div>

            
            <div id="result">
                <template id="entrepriseTemplate">
                    <div class="cardStyle">
                        <p>Nom : <span id="nom_complet"></span></p>
                        <p>Numero SIREN : <span id="siren"></span></p>
                        <p>Taille : <span id="categorie_entreprise"></span></p>
                        <p>Activité principale : <span id="activite_principale"></span></p>
                        <p>Date de création : <span id="date_creation"></span></p>
                    </div>
                </template>
            </div>
        </div>
    </body>
</html>