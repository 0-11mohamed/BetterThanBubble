<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

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

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>