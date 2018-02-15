<?php

require_once ('inc/init.inc.php');

//2- deconnexion de l'internaute :
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){
  //si l'internaute a cliqué sur deconnexion : on supprime sa session:
  session_destroy(); //on supprime la session du membre
}

//3- cas de l'internaute deja connecté : on le renvoie vers son profil:
if (internauteEstConnecte()) {
  header('location:profil.php');//on redirige l'internaute vers son profil s'il est déjà connecté
  exit();
}



// 1 - traitement du formulaire et remplissage de la SESSION:
if (!empty($_POST)) {
  // var_dump($_POST);

  if (!isset($_POST['pseudo']) || empty($_POST['pseudo'])) {
    //si pseudo n'existe pas ou est vide :
    $contenu .= '<div class="bg-danger">Le pseudo est requis.</div>';
  }

  if (!isset($_POST['mdp']) || empty($_POST['mdp'])) {
    //si pseudo n'existe pas ou est vide :
    $contenu .= '<div class="bg-danger">Le mot de passe est requis.</div>';
  }

  if (empty($contenu)) {
    //si $contenu est vide, il n'y a pas de message d'erreur. On requete donc le pseudo et le mdp en BDD
    $mdp = md5($_POST['mdp']); //on crypte pour comparer 2 mdp cryptés

    $resultat = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo AND mdp = :mdp",array(':pseudo' => $_POST['pseudo'], ':mdp' => $mdp));

    if($resultat->rowCount() != 0){//si différent de 0 il est bien enregistré
        //si il y a une ligne dans le resultat de la requete, alors le pseudo et le mdp existent et correspondent
        $membre = $resultat->fetch(PDO::FETCH_ASSOC);
        //pas de boucle while car on est sur qu'il n'y a qu'un seul résultat
        var_dump($membre);

        $_SESSION['membre'] = $membre; //nous créons une session avec toutes les infos du membre
        //var_dump($_SESSION);
        header('location:profil.php'); //le membre étant connecté on l'envoie vers son profil
        exit(); //pour quitter ce script
    }else{
      $contenu .= '<div class="bg-danger">Erreur sur les identifiants.</div>';

    }
  }
}


require_once ('inc/haut.inc.php');
echo $contenu;
?>
<h3>Formulaire de connexion</h3>
<form class="" action="" method="post">
  <label for="pseudo">Pseudo</label><br>
  <input type="text" name="pseudo" id="pseudo" value=""><br>

  <label for="mdp">Mot de passe</label><br>
  <input type="password" name="mdp" id="mdp" value=""><br>

  <input type="submit" class="btn" value="se connecter"><br>



</form>




<?php
require_once ('inc/bas.inc.php');

 ?>
