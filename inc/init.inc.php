<?php

//Connexion à la BDD :
// $pdo = new PDO('mysql:host=localhost;dbname=dealwizit', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

try {
  $pdo = new PDO('mysql:host=serflex.o2switch.net;dbname=aoranosh_dealwizit', 'aoranosh', '_+XJPdXAA0Hp', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
  //il faut changer le localhost, le dbname, l'id, le mdp
    // return$pdo;
} catch (PDOException $e) {
  $f = fopen('error.txt', 'a');
  $erreur = 'erreur SQL : ' . $e->getMessage() . ' - date :' . time('d/m/Y') ."\r\n";
  fwrite($f, $erreur);
  die('erreur : ' . $e->getMessage());
}

//il faut changer le localhost, le dbname, l'id, le mdp

//Création ou ouverture d'une SESSION:
session_start();

//Définition du chemin du site :
define('RACINE_SITE', '/portfolio/dealwizit/'); //indiquer le dossier dans lequel ce trouve le site sans "localhost"
//changer la racine du fichier
// Initialisation des variables d'affichage :

$contenu = '';
$contenu_gauche = '';
$contenu_droite = '';

//Inclusion du fichier comportant les fonctions :
require_once('fonction.inc.php');

 ?>
