<?php
require_once 'connexion.php';

// Récupération des données de la base de données
$sql = "SELECT * FROM stages";
$stmt = $db->prepare($sql);
$stmt->execute();
$stages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Affichage des données
foreach ($stages as $stage) {
    echo "<p>" . htmlspecialchars($stage['titre']) . "</p>";
}