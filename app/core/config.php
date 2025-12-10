<?php
    $db_username   = "onlystages";
    $db_password   = "uyi4Hai8ad8Ohgh3";
    $dbname     = "onlystages_bd";
    $host = "localhost";

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_username, $db_password);
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
?>