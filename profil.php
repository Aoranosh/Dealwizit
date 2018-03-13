<?php

require_once ('inc/init.inc.php');


//si l'internaute n'est pas co, on le redirige vers le formulaire de co
if (!internauteEstConnecte()) {
  header('location:connexion.php'); // on affiche la page de co
  exit();
}

//préparation du profil à afficher
//var_dump($_SESSION);
$contenu .= '<br><h2></span>Bonjour <strong> <span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span> ' . $_SESSION['membre']['prenom'] . ' <span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span>' . '</strong></h2>';
$contenu .= '<h6>C\'est un beau jour pour faire un bon deal !</h6><br>';
if (internauteEstConnecte()) {
  $contenu .= '<ol class="breadcrumb col-sm-8">
  <li><a href="index.php">Les petites annonces</a></li>
  <li><a href="admin/gestion_annonces.php?action=ajout">J\'écris ma petite annonce</a></li>
  <li><a href="contact.php">Contact</a></li>
  <li><a href="connexion.php?action=deconnexion">Déconnexion</a></li>
  </ol><br><br>';
}



if (internauteEstConnecteEtEstAdmin()) {
  $contenu .= '<br><h3>Vous êtes Administrateur</h3><br>';
}

$contenu .= '<br><div><h4>Voici vos informations de profil : </h4>';
  $contenu .= '<p>Votre email : ' . $_SESSION['membre']['email'] . '</p>';
  $contenu .= '<p>Votre pseudo : ' . $_SESSION['membre']['pseudo'] . '</p><br><hr>';
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
