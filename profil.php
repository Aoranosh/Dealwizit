<?php

require_once ('inc/init.inc.php');


//si l'internaute n'est pas co, on le redirige vers le formulaire de co
if (!internauteEstConnecte()) {
  header('location:connexion.php'); // on affiche la page de co
  exit();
}

//préparation du profil à afficher
//var_dump($_SESSION);

$contenu .= '<br><h2></span>Bonjour <strong> <span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span> ' . $_SESSION['membre']['prenom'] . ' <span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span>' . '</strong></h2><br>';


if (internauteEstConnecteEtEstAdmin()) {
  $contenu .= '<h3>Vous êtes Administrateur</h3><br>';
}

$contenu .= '<div><h4>Voici vos informations de profil : </h4>';
  $contenu .= '<p>Votre email : ' . $_SESSION['membre']['email'] . '</p>';
  $contenu .= '<p>Votre pseudo : ' . $_SESSION['membre']['pseudo'] . '</p><br>';
  // $contenu .= '<p>Votre mot de passe : ' . $_SESSION['membre']['mdp'] . '</p><br>';
  $contenu .= '<h4>Voici vos informations personnelles : </h4>';
  $contenu .= '<p>Votre prénom : ' . $_SESSION['membre']['prenom'] . '</p>';
  $contenu .= '<p>Votre nom : ' . $_SESSION['membre']['nom'] . '</p>';
  $contenu .= '<p>Votre telephone : ' . $_SESSION['membre']['telephone'] . '</p>';

$contenu .= '</div>';

?>


<?php

require_once ('inc/haut.inc.php');

echo $contenu;

require_once ('inc/bas.inc.php');




 ?>
