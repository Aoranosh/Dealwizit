<?php

function internauteEstConnecte() {
  if(isset($_SESSION['membre'])){
    return true;//si la session membre existe c'est que l'internaute s'est connecté (voir connexion .php)
  } else {
    return false;
  }
} //fonction qui vérifie qu'un membre est administrateur connecté:

function internauteEstConnecteEtEstAdmin(){
  if(internauteEstConnecte() && $_SESSION['membre']['role'] == 'admin'){
    return true;
  } else {
    return false;
  }
}

//-----------------------
//Fonction qui exécute des requetes préparées SQL:
function executeRequete($req, $param = array()){

  //var_dump($param);

  if (!empty($param)) {
    foreach ($param as $indice => $valeur) {
      $param[$indice] = htmlspecialchars($valeur, ENT_QUOTES);

    }
  }
  global $pdo;

  $r = $pdo->prepare($req);
  $r->execute($param);

  return $r;
}

function debug($tab){

	echo '<div style="background:#'. rand(111111, 999999) .'; color: white; padding:10px;">';

	$debug = debug_backtrace();

	echo '<p>Le debug a été demandé dans le fichier <b><u>'. $debug[0]['file'] .'</u></b> à la ligne <b><u>'. $debug[0]['line'] .'</u></b></p><hr>';
	echo '<pre>';
	print_r($tab);
	echo '</pre>';
	echo '</div>';
}
