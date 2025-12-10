<?php
    $host = 'localhost';
    $db_username = "root";
    $db_password = "";
    $dbname = "bdddxp";
    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_username, $db_password);
        echo "Connexion réussie !";
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
?>