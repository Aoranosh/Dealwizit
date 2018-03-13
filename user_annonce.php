<?php
require_once('../inc/init.inc.php');

// if (!internauteEstConnecteEtEstAdmin()) {
//     header('location:../connexion.php');
//     exit();
//   }
  //var_dump($_SESSION['membre']);

 if (isset($_GET['action']) && $_GET['action'] == 'suppression' && isset($_GET['id'])) {
   $resultat2 = executeRequete("SELECT * FROM annonce WHERE id = :id", array(':id' => $_GET['id'] ));

   if ($resultat2->rowCount() == 1) {
     executeRequete("DELETE FROM annonce WHERE id = :id", array(':id' => $_GET['id']));

     $contenu2 .= '<div class ="bg-success">L\'annonce a bien été supprimé ! </div>';
   }else {
     $contenu2 .= '<div class ="bg-warning">L\'annonce n\'existe pas ! </div>';
   }
   $_GET['action'] = 'affichage';
 }

 if ($_POST) {
 $photo_bdd = '';

 if (isset($_GET['action']) && $_GET['action'] == 'modification') {
   $photo_bdd = $_POST['photo_actuelle']; //on prend la valeur de l'input "photo_actuelle" du formulaire

 }

 if (!empty($_FILES['photo']['name'])) {
     //var_dump($_FILES);
     $nom_photo = $_POST['titre'] . '_' . $_FILES['photo']['name'];
     $photo_bdd = 'portfolio/dealwizit/photo/' . $nom_photo;
     $photo_physique = $_SERVER['DOCUMENT_ROOT'] . $photo_bdd;
     copy($_FILES['photo']['tmp_name'], $photo_physique);
 }

if(!empty($_POST['id'])){
 executeRequete("REPLACE INTO annonce (titre, description_courte, prix, photo, pays, ville, adresse, code_postal, membre_id, categorie_id, description_longue, date_enregistrement) VALUES (:titre, :description_courte, :prix, :photo, :pays, :ville, :adresse, :code_postal, :membre_id, :categorie_id, :description_longue,  NOW())", array(
   ':id'   => $_POST['id'],
   ':titre'    => $_POST['titre'],
   ':description_courte'  => $_POST['description_courte'],
   ':prix'         => $_POST['prix'],
   ':photo'        => $photo_bdd,
   ':pays'      => $_POST['pays'],
   ':ville'       => $_POST['ville'],
   ':adresse'       => $_POST['adresse'],
   ':code_postal'       => $_POST['code_postal'],
   ':membre_id'    => $_SESSION['membre']['id'],
   ':categorie_id'    => $_POST['id'],
   ':description_longue'  => $_POST['description_longue'],
   )
);
} else {
 executeRequete("INSERT INTO annonce (titre, description_courte, prix, photo, pays, ville, adresse, code_postal, membre_id, categorie_id, description_longue, date_enregistrement) VALUES (:titre, :description_courte, :prix, :photo, :pays, :ville, :adresse, :code_postal, :membre_id, :categorie_id, :description_longue,  NOW())", array(
   // ':id'   => $_POST['id'],
   ':titre'    => $_POST['titre'],
   ':description_courte'  => $_POST['description_courte'],
   ':prix'         => $_POST['prix'],
   ':photo'        => $photo_bdd,
   ':pays'      => $_POST['pays'],
   ':ville'       => $_POST['ville'],
   ':adresse'       => $_POST['adresse'],
   ':code_postal'       => $_POST['code_postal'],
   ':membre_id'    => $_SESSION['membre']['id'],
   ':categorie_id'    => $_POST['id'],
   ':description_longue'  => $_POST['description_longue'],
   )
);
}
//var_dump($_POST);
 $contenu2 .= '<div class="bg-success">Le annonce a été enregistré ! </div><br><br>';

 $_GET['action'] = 'affichage';

 }//fin du if


 if (isset($_GET['action']) && $_GET['action'] == 'affichage') {

   // $resultat2 = executeRequete("SELECT * FROM annonce");

   $resultat2 = executeRequete("SELECT annonce.id, annonce.titre, annonce.description_courte, annonce.description_longue, annonce.prix, annonce.photo, annonce.pays, annonce.ville, annonce.adresse, annonce.code_postal, membre.prenom, categorie.titre AS categorie_titre, annonce.date_enregistrement FROM annonce, categorie, membre where annonce.categorie_id = categorie.id and membre.id = annonce.membre_id");

   $contenu2 .= 'Nombre d\'annonces dans la boutique : ' . $resultat2->rowCount();

   $contenu2 .= '<div class="table-responsive">';
   $contenu2 .= '<table class="table">';
     $contenu2 .= '<tr>';
       $contenu2 .= '<th>Id</th>';
       $contenu2 .= '<th>Titre</th>';
       $contenu2 .= '<th>Description courte</th>';
       $contenu2 .= '<th>Description longue</th>';
       $contenu2 .= '<th>Prix</th>';
       $contenu2 .= '<th>Photo</th>';
       $contenu2 .= '<th>Pays</th>';
       $contenu2 .= '<th>Ville</th>';
       $contenu2 .= '<th>Adresse</th>';
       $contenu2 .= '<th>Code postal</th>';
       $contenu2 .= '<th>Membre</th>';
       $contenu2 .= '<th>Catégorie</th>';
       $contenu2 .= '<th>Date enregistrement</th>';
       $contenu2 .= '<th>Actions</th>';
     $contenu2 .= '</tr>';

   while ($ligne = $resultat2->fetch(PDO::FETCH_ASSOC)) {
     //var_dump($ligne); //$ligne est un array associatif avec le nom des champs de la table annonce en indice

     $contenu2 .= '<tr>';
     foreach ($ligne as $indice => $information) {
       if ($indice == 'photo') {
           $contenu2 .= '<td><img src ="/portfolio/'. $information .'" width="90" height="70"></td>';
       }else{
           $contenu2 .= '<td>'. $information .'</td>';

       }

     }
     $contenu2 .= '<td>
                   <a href="?action=modification&id='. $ligne['id'] .'"><button type="button" class="btn btn-primary"> Modifier </button></a>
                   <a href="?action=suppression&id='. $ligne['id'] .'" onclick="return(confirm(\'Etes-vous sûr de vouloir de supprimer cette annonce ?\'))" ><button type="button" class="btn btn-danger">Supprimer</button></a>
                 </td>';
     $contenu2 .= '</tr>';
   }

   $contenu2 .= '</table>';
   $contenu2 .= '</div>';
 }

 //affichage-----------------------------------------------------
 require_once('../inc/haut.inc.php');

 echo '<ul class="nav nav-tabs">
       <li><a href="?action=affichage">Affichage d\'annonces</a></li>
       <li><a href="?action=ajout">Ajout d\'annonces</a></li>
       </ul>';

 echo $contenu2;

 if (isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')) :
   $resultat2 = executeRequete("SELECT * FROM categorie");
  $toutescategories = '<select name="id">';

  while ($row = $resultat2->fetch(PDO::FETCH_ASSOC)) {
      $toutescategories .= "<option value=\"" .$row['id']. "\" >" . $row['titre'] ."</option>\n";
  }
      $toutescategories .= '</select>';

 if (isset($_GET['id'])) {

     $resultat2 = executeRequete("SELECT * FROM annonce WHERE id = :id", array(":id" => $_GET['id']));
     $annonce_actuel = $resultat2->fetch(PDO::FETCH_ASSOC);

 }

   ?>

 <br><br><h4>Formulaire d'ajout ou de modification des annonces</h4>
 <form enctype="multipart/form-data" action="" method="post">
 <input type="hidden" id="id" name="id" value="<?php
 echo $annonce_actuel['id'] ?? 0;  ?>"><br><br>

 <label for="titre">Titre</label><br>
 <input type="text" id="titre" name="titre" value="<?php
 echo $annonce_actuel['titre'] ?? '';  ?>"><br><br>

 <label for="description_courte">Description courte</label><br>
 <input type="text" id="description_courte" name="description_courte" value="<?php
 echo $annonce_actuel['description_courte'] ?? '';  ?>"><br><br>

 <label for="prix">Prix</label><br>
 <input type="text" id="prix" name="prix" value="<?php
 echo $annonce_actuel['prix'] ?? 0;  ?>"><br><br>

 <label for="photo">Photo</label><br>
 <input type="file" id="photo" name="photo" value=""><br><br>
 <?php
 if (isset($annonce_actuel['photo'])) {
   echo '<i>Vous pouvez uploader une nouvelle photo</i>';
   echo '<p>Photo actuelle : </p>';
   echo '<img src="/portfolio/'. $annonce_actuel['photo'] .'" width="90" height="90"><br>';
   echo '<input type="hidden" name="photo_actuelle" value="'. $annonce_actuel['photo'] .'">';

 }

 ?>

 <label for="pays">Pays</label><br>
 <input type="text" id="pays" name="pays" value="<?php
 echo $annonce_actuel['pays'] ?? '';  ?>"><br><br>

 <label for="ville">Ville</label><br>
 <input type="text" id="ville" name="ville" value="<?php
 echo $annonce_actuel['ville'] ?? '';  ?>"><br><br>

 <label for="adresse">Adresse</label><br>
 <input type="text" id="adresse" name="adresse" value="<?php
 echo $annonce_actuel['adresse'] ?? '';  ?>"><br><br>

 <label for="code_postal">Code postal</label><br>
 <input type="text" id="code_postal" name="code_postal" value="<?php
 echo $annonce_actuel['code_postal'] ?? '';  ?>"><br><br>

 <!-- <label for="membre_id">Membre</label><br>
 <input type="text" id="membre_id" name="membre_id" value="<?//php
 //echo $annonce_actuel['membre_id'] ?? '';  ?>"><br><br> -->


 <label for="categorie_id">Catégorie</label><br>
 <?php echo $toutescategories; ?><br><br>

 <!-- <input type="text" id="categorie_id" name="categorie_id" value="<?php
 //echo $annonce_actuel['categorie_id'] ?? '';  ?>"><br><br> -->

 <label for="description_longue">Description longue</label><br>
 <input type="text" id="description_longue" name="description_longue" value="<?php
 echo $annonce_actuel['description_longue'] ?? '';  ?>"><br><br>

 <input type="submit" name="" class="btn" value="Valider"><br><br>
 </form>


 <?php
 endif;

 require_once ('../inc/bas.inc.php');

  ?>
