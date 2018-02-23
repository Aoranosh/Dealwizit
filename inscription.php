<?php

require_once ('inc/init.inc.php');

//traitement du POST (du formulaire) :
if(!empty($_POST)) {
  //si le $_POST est rempli :
  // var_dump($_POST);

  //validation du formulaire :
  if (!isset($_POST['pseudo']) || strlen($_POST['pseudo']) < 4  || strlen($_POST['pseudo']) > 20) {
    $contenu .= '<div class="bg-danger">Le pseudo est incorrect !</div>';
  }

  if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 4  || strlen($_POST['mdp']) > 20) {
    $contenu .= '<div class="bg-danger">Le mot est incorect est incorrect !</div>';
  }

  if (!isset($_POST['nom']) || strlen($_POST['nom']) < 2  || strlen($_POST['nom']) > 20) {
    $contenu .= '<div class="bg-danger">Le nom est incorrect !</div>';
  }

  if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2  || strlen($_POST['prenom']) > 20) {
    $contenu .= '<div class="bg-danger">Le prénom est incorrect !</div>';
  }

  if (!isset($_POST['telephone']) || strlen($_POST['telephone']) < 2  || strlen($_POST['telephone']) > 20) {
    $_POST['telephone'] = htmlspecialchars($_POST['telephone']);
    if (preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $_POST['telephone'])) {
      $contenu .= '<div class="bg-success">Le '. $_POST['telephone'] .' est un numéro <strong>valide</strong> !</div>';
    }else {
      $contenu .= '<div class="bg-danger">Le téléphone est incorrect !</div>';
    }
  }

  //email:
  //on utilise un filtre de variable
  if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $contenu .='<div class="bg-danger">L\'email est incorrect ! </div>';
  }//filer_var() permet de valider des formats de variables, ici qu'il s'agit d'un email
  //retourne true si exact, retourne false dans le cas contraire

//Si pas d'erreur dans le formulaire on vérifié l'unicité du pseudo puis on l'insert en BDD :
if (empty($contenu)) {
  //si la variable est vide, c'est qu'il n'y a pas de message d'erreur, on fait donc un select pour vérif le pseudo
  $membre = executeRequete("SELECT * FROM membre WHERE pseudo =:pseudo",array(':pseudo'=> $_POST['pseudo']));

  if($membre->rowCount() > 0){
    //si la requête retourne 1 ou plusieurs lignes, c'est que le pseudo est deja en BDD
    //on demande donc d'en choisir un autre:
    $contenu .= '<div class="bg-danger">Le pseudo est indisponible. Veuillez en choisir un autre. </div>';
  }else {
    $_POST['mdp'] = sha1($_POST['mdp']); // Si on encrypte un MDP avec cette fonction, il faudra également le faire sur la page de connexion pour comparer 2 MDP cryptés
  //  echo'<pre>'; var_dump($_POST['mdp']); echo'</pre>';

    executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, telephone, email, civilite, role, date_enregistrement) VALUES(:pseudo, :mdp, :nom, :prenom, :telephone, :email, :civilite, 'user', NOW())",
    array(':pseudo' => $_POST['pseudo'],
    ':mdp'=> $_POST['mdp'],
    ':nom'=> $_POST['nom'],
    ':prenom'=> $_POST['prenom'],
    ':telephone'=> $_POST['telephone'],
    ':email'=> $_POST['email'],
    ':civilite'=> $_POST['civilite']));
var_dump($_POST);
  $contenu .= '<div class="bg-success">Vous êtes inscrit.<a href="connexion.php">Cliquez pour vous connecter</a></div>';

  }
}

} //fin de if (!empty($_POST))

require_once ('inc/haut.inc.php');
echo $contenu; //stock les messages pour l'utilisateur


 ?>
<h3>Veuillez renseigner le formulaire pour vous inscrire</h3>

<form class="" action="" method="post">
  <label for="pseudo">Pseudo</label><br>
  <input type="text" id="pseudo" name="pseudo" value=""><br>

  <label for="mdp">Mot de passe</label><br>
  <input type="password" id="mdp" name="mdp" value=""><br>

  <label for="nom">Nom</label><br>
  <input type="text" id="nom" name="nom" value=""><br>

  <label for="prenom">Prénom</label><br>
  <input type="text" id="prenom" name="prenom" value=""><br>

  <label for="telephone">Tel</label><br>
  <input type="text" id="telephone" name="telephone" value=""><br>

  <label for="email">Email</label><br>
  <input type="text" id="email" name="email" value=""><br>

  <label>Civilité</label><br>
  <input type="radio" id="civilite" name="civilite" value="M" checked>
  <label for="civilite">M</label>
  <input type="radio" id="civilite" name="civilite" value="Mme">
  <label for="civilite">Mme</label><br>

  <input type="submit"  value="s'inscrire" class="btn"><br>

</form>

<?php


require_once ('inc/bas.inc.php');
 ?>
