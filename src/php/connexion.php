<?php

$db_username = "onlystages";
$db_password = "uyi4Hai8ad8Ohgh3";
$host = 'localhost';
//echo 'test premier';

//$db = fabriquerChaineConnexPDO();
try
{

	//echo 'test ctach';
    $db = new PDO('mysql:host=localhost;dbname=onlystages_bd;charset=utf8', 'onlystages', 'uyi4Hai8ad8Ohgh3'); // insérez vos paramètres de connexion à la BDD.
	//Remplace la base de connexion
	//echo 'test ctach';

}

// Gestion des erreurs
catch(Exception $e)
{
 die('Erreur : '.$e->getMessage());
}  