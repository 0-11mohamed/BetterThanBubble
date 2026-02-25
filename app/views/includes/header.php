<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlyStage</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
            <div id="titleZone">
                <a class="flex-row" href="home">  
                    <img src="public/img/logo/oslogo.png">
                    <p id="titre">OnlyStage</p>
                </a>
            </div>

            <div id="menubar">
                <?php 
                if(isset($_SESSION['user_id'])){
                    
                    echo'<a class="inputStyle" href="home">Accueil</a>';
                    echo'<a class="inputStyle" href="companies">Entreprises</a>';
                    echo'<a class="inputStyle" href="stages">Stages</a>';
                    if($_SESSION['typecompte']===3){
                        echo'<a class="inputStyle" href="import">Importer mes données</a>';
                    }
                    echo'<a class="inputStyle" href="logoff">Deconnecter</a>';
                }
                else{

                }
                 ?>
            </div>

    </header>