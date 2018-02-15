<?php

require_once ('../inc/init.inc.php'); //on va d'abord dans le dossier parent puis dans le dossier

//1- on vérifie que le membre est admin
if (!internauteEstConnecteEtEstAdmin()) {
    header('location:../connexion.php'); //si pas admin on le renvoie à la co
    exit();//on sort du script

}

//7- Traitement de la suppression d'un produit :
if (isset($_GET['action']) && $_GET['action'] == 'suppression' && isset($_GET['id'])) {
  $resultat = executeRequete("SELECT * FROM annonce WHERE id = :id", array(':id' => $_GET['titre'] ));

  if ($resultat->rowCount() == 1) {
    //si j'ai une ligne dans $resultat c'est que le produit existe bien en BDD : je peux donc le supprimer
    executeRequete("DELETE FROM annonce WHERE id = :id", array(':id' => $_GET['titre']));

    $contenu .= '<div class ="bg-success">Le produit a bien été supprimé ! </div>';
  }else {
    $contenu .= '<div class ="bg-warning">Le produit n\'existe pas ! </div>';
  }
  $_GET['action'] = 'affichage';
  //pour forcer l'afficahge du <table> contenant tous les produits
}

//4- traitement du formulaire : enregistrement du produit :
if ($_POST) {
//  var_dump($_POST);
$photo_bdd = '';

//9- suite modification de la photo :
//si on est en modification, on récupère le chemin de la photo de la BDD mis dans le formulaire de modification :
if (isset($_Get['action']) && $_GET['action'] == 'modification') {
  $photo_bdd = $_POST['photo_actuelle']; //on prend la valeur de l'input "photo_actuelle" du formulaire

}


//5- traitement de l'up de la photo
if (!empty($_FILES['photo']['name'])) {
    //var_dump($_FILES);

    //variable qui contient le nom du fichier photo final :
    $nom_photo = $_POST['reference'] . '_' . $_FILES['photo']['name'];
    //on crée un nom de fichier unique pour ne pas écraser une photo deja existante
    //variable qui contient le chemin de la photo enregistré en BDD
    $photo_bdd = RACINE_SITE . 'photo/' . $nom_photo;
    //la photo est enregistré dans le dossier "photo" de notre site

    //variable qui contient le chemin COMPLE pour enregistrer le fichier physique de la photo :
    $photo_physique = $_SERVER['DOCUMENT_ROOT'] . $photo_bdd;
    //la superglobale $_SERVER['DOCUMENT_ROOT'] correspond à notre local host, càd à "C:/wamp64/www"

    //enregistrement du fichier photo physique:
    copy($_FILES['photo']['tmp_name'], $photo_physique); //il existe donc deux étapes pour le up de la photo
    //enregistre temporairement la photo à $_FILES['photo']['tmp_name'], à l'endroit $photo_physique

}

//4- suite : enregistrement en BDD
executeRequete("REPLACE INTO annonce (id, membre_id, categorie_id, titre, description_courte, adresse, adresse, ville, code_postal, pays, photo, prix) VALUES(:id, :membre_id, :categorie_id, :titre, :description_courte, :adresse, :ville, :code_postal, :pays, :photo, :prix)", array(
  ':id'   => $_POST['id'],
  ':membre_id'    => $_POST['membre_id'],
  ':categorie'    => $_POST['categorie_id'],
  ':titre'        => $_POST['titre'],
  ':description'  => $_POST['description_courte'],
  ':adresse'      => $_POST['adresse'],
  ':ville'       => $_POST['ville'],
  ':code_postal'  => $_POST['code_postal'],
  ':pays'  => $_POST['pays'],
  ':photo'        => $photo_bdd,
  ':prix'         => $_POST['prix'],
));

$contenu .= '<div class="bg-success">Le produit a été enregistré ! </div><br><br>';

$_GET['action'] = 'affichage'; //pour déclencher l'affichage automatique du table avec tous les produits (voir point 6 de ce script)

}//fin du if


//6- Affichage des produits sous forme de <table>
if (isset($_GET['action']) && $_GET['action'] == 'affichage') {
  //si on a cliqué sur l'onglet affichage des produits

  $resultat = executeRequete("SELECT * FROM produit");
  //on selectionne tous les produits en bdd

  //on prépare l'affichage dans $contenu:
  $contenu .= 'Nombre de produits dans la boutique : ' . $resultat->rowCount();

  $contenu .= '<table class="table">';
    $contenu .= '<tr>';
      $contenu .= '<th>id_annonce</th>';
      $contenu .= '<th>id_membre</th>';
      $contenu .= '<th>catégorie</th>';
      $contenu .= '<th>titre</th>';
      $contenu .= '<th>description</th>';
      $contenu .= '<th>adresse</th>';
      $contenu .= '<th>ville</th>';
      $contenu .= '<th>code postal</th>';
      $contenu .= '<th>pays</th>';
      $contenu .= '<th>photo</th>';
      $contenu .= '<th>prix</th>';
      $contenu .= '<th>actions</th>';
    $contenu .= '</tr>';

  //Affichage des lignes de produits :
  while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
    //var_dump($ligne); //$ligne est un array associatif avec le nom des champs de la table produit en indice

    $contenu .= '<tr>';
    //on parcourt l'array $ligne qui représente 1 produit pour obtenir toutes ses informations
    foreach ($ligne as $indice => $information) {
      ///traitement de la photo:
      if ($indice == 'photo') {
          $contenu .= '<td><img src ="'. $information .'" width="90" height="70"></td>';
      }else{
          $contenu .= '<td>'. $information .'</td>';

      }

    }
    //ajout des liens actions :
    $contenu .= '<td>
                  <a href="?action=modification&id='. $ligne['id'] .'">modifier</a>
                  /
                  <a href="?action=suppression&id_produit='. $ligne['id'] .'" onclick="return(confirm(\'Etes-vous sûr de vouloir de supprimer ce produit ?\'))" >supprimer</a>
                </td>';
    $contenu .= '</tr>';
  }

  $contenu .= '</table>';
}


//affichage-----------------------------------------------------
require_once ('adminhaut.inc.php');
//2- Onglets "ajout" et "affichage" des produits;
echo '<ul class="nav nav-tabs">
      <li><a href="?action=affichage">Affichage de produits</a></li>
      <li><a href="?action=ajout">Ajout de produits</a></li>
      <ul>';

echo $contenu;


//3- Formulaire html de produit
if (isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')) :
//syntaxe ne "if() :instructions; endif;". il y a donc un endif; tout en bas du script

//8- préremplissage du formulaire pour la modification d'un produit existant :
if (isset($_GET['id'])) {
    //on ba généré un array afin de pouvoir le réutiliser en dessous
    //j'entre ici uniquement en modification car c'est le seul cas ou l'id_produit est passé dans l'url (en effet en ajout il n'y a pas d'id_produit dans l'url)

    $resultat = executeRequete("SELECT * FROM annonce WHERE id = :id", array(":id" => $_GET['titre']));
    $produit_actuel = $resultat->fetch(PDO::FETCH_ASSOC);
    //on obtient un array contenant toutes les infos du produit à modifier : je peux donc les afficher dans le formulaire ci-dessous


}


  ?>
<h3>Formulaire d'ajout ou de modification de produits</h3>
<form enctype="multipart/form-data" action="" method="post"><br>
<!-- enctype spécifie que le formulaire permet d'uploader un ou des fichiers (ici photo) -->
<input type="hidden" id="id" name="id" value="<?php
echo $produit_actuel['id'] ?? 0;  ?>"><br><br>
<!-- champs caché utile pour la modification d'un produit car on a beosin de son id pour la requete sql de modification -->
<label for="membre_id">Membre</label><br>
<input type="text" id="membre_id" name="membre_id" value="<?php
echo $produit_actuel['membre_id'] ?? '';  ?>"><br><br>

<label for="categorie_id">Catégorie</label><br>
<input type="text" id="categorie_id" name="categorie_id" value="<?php
echo $produit_actuel['categorie_id'] ?? '';  ?>"><br><br>

<label for="titre">Titre</label><br>
<input type="text" id="titre" name="titre" value="<?php
echo $produit_actuel['titre'] ?? '';  ?>"><br><br>

<label for="description_courte">Description</label><br>
<input type="text" id="description_courte" name="description_courte" value="<?php
echo $produit_actuel['description_courte'] ?? '';  ?>"><br><br>

<label for="adresse">Adresse</label><br>
<input type="text" id="adresse" name="adresse" value="<?php
echo $produit_actuel['adresse'] ?? '';  ?>"><br><br>

<label for="ville">Ville</label><br>
<input type="text" id="ville" name="ville" value="<?php
echo $produit_actuel['ville'] ?? '';  ?>"><br><br>

<label for="code_postal">code Postal</label><br>
<input type="text" id="code_postal" name="code_postal" value="<?php
echo $produit_actuel['code_postal'] ?? '';  ?>"><br><br>

<label for="pays">Pays</label><br>
<input type="text" id="pays" name="pays" value="<?php
echo $produit_actuel['pays'] ?? '';  ?>"><br><br>

<label for="photo">Photo</label><br>
<input type="file" id="photo" name="photo" value=""><br><br>
<!-- pour utiliser le type file, ne pas oublier l'enctype="multipart/form-data"  -->

<?php
//9 - Modification de la photo:
if (isset($produit_actuel['photo'])) {
  echo '<i>Vous pouvez uploader une nouvelle photo</i>';
  echo '<p>Photo actuelle : </p>';
  echo '<img src="'. $produit_actuel['photo'] .'" width="90" height="90"><br>';
  echo '<input type="hidden" name="photo_actuelle" value="'. $produit_actuel['photo'] .'">';


}

 ?>

<label for="prix">Prix</label><br>
<input type="text" id="prix" name="prix" value="<?php
echo $produit_actuel['prix'] ?? 0;  ?>"><br><br>

<input type="submit" name="" class="btn" value="valider"><br><br>
</form>


<?php
endif; //le endif avec ":" permet de remplacer les accollades des conditions de if
//c'est une syntaxe qui permet de mélanger plusieurs languages dans une meme boucle


require_once ('../inc/bas.inc.php');

 ?>
