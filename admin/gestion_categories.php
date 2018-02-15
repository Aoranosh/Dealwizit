<?php
require_once('../inc/init.inc.php');

if (!internauteEstConnecteEtEstAdmin()) {
    header('location:../connexion.php');
    exit();
  }
  //var_dump($_SESSION['membre']);

 if (isset($_GET['action']) && $_GET['action'] == 'suppression' && isset($_GET['id'])) {
   $resultat = executeRequete("SELECT * FROM categorie WHERE id = :id", array(':id' => $_GET['id'] ));

   if ($resultat->rowCount() == 1) {
     executeRequete("DELETE FROM categorie WHERE id = :id", array(':id' => $_GET['id']));

     $contenu .= '<div class ="bg-success">La catégorie a bien été supprimée ! </div>';
   }else {
     $contenu .= '<div class ="bg-warning">La catégorie n\'existe pas !</div>';
   }
   $_GET['action'] = 'affichage';
 }

 if ($_POST) {


if(!empty($_POST['id'])){
     executeRequete("REPLACE INTO categorie (id, titre, mots_cles) VALUES (:id, :titre, :mots_cles)", array(
       ':id'   => $_POST['id'],
       ':titre'    => $_POST['titre'],
       ':mots_cles'  => $_POST['mots_cles'],
       )
    );
} else{
   executeRequete("INSERT INTO categorie (titre, mots_cles) VALUES (:titre, :mots_cles)", array(
     // ':id'   => $_POST['id'],
     ':titre'    => $_POST['titre'],
     ':mots_cles'  => $_POST['mots_cles'],
     )
  );
}
//var_dump($_POST);
 $contenu .= '<div class="bg-success">La catégorie a été enregistrée ! </div><br><br>';

 $_GET['action'] = 'affichage';

 }//fin du if


 if (isset($_GET['action']) && $_GET['action'] == 'affichage') {

   $resultat = executeRequete("SELECT * FROM categorie");

   $contenu .= 'Nombre de catégories dans la boutique : ' . $resultat->rowCount();

   $contenu .= '<table class="table">';
     $contenu .= '<tr>';
       $contenu .= '<th>id</th>';
       $contenu .= '<th>titre</th>';
       $contenu .= '<th>mots_cles</th>';
     $contenu .= '</tr>';

   while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
     //var_dump($ligne); //$ligne est un array associatif avec le nom des champs de la table categorie en indice

     $contenu .= '<tr>';
     foreach ($ligne as $indice => $information) {
       if ($indice == 'photo') {
           $contenu .= '<td><img src ="'. $information .'" width="90" height="70"></td>';
       }else{
           $contenu .= '<td>'. $information .'</td>';

       }

     }
     $contenu .= '<td>
                   <a href="?action=modification&id='. $ligne['id'] .'">modifier</a>
                   /
                   <a href="?action=suppression&id='. $ligne['id'] .'" onclick="return(confirm(\'Etes-vous sûr de vouloir de supprimer cette catégorie ?\'))" >supprimer</a>
                 </td>';
     $contenu .= '</tr>';
   }

   $contenu .= '</table>';
 }


 //affichage-----------------------------------------------------
 require_once ('adminhaut.inc.php');
 echo '<ul class="nav nav-tabs">
       <li><a href="?action=affichage">Affichage des catégories</a></li>
       <li><a href="?action=ajout">Ajout d\'une catégorie</a></li>
       <ul>';

 echo $contenu;


 if (isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')) :

 if (isset($_GET['id'])) {

     $resultat = executeRequete("SELECT * FROM categorie WHERE id = :id", array(":id" => $_GET['id']));
     $categorie_actuelle = $resultat->fetch(PDO::FETCH_ASSOC);

 }

   ?>

 <br><br><h4>Formulaire d'ajout ou de modification des categories</h4>
 <form enctype="multipart/form-data" action="" method="post">
 <input type="hidden" id="id" name="id" value="<?php
 echo $categorie_actuelle['id'] ?? '';  ?>"><br><br>

 <label for="titre">Titre</label><br>
 <input type="text" id="titre" name="titre" value="<?php
 echo $categorie_actuelle['titre'] ?? '';  ?>"><br><br>

 <label for="mots_cles">Mots cles</label><br>
 <input type="text" id="mots_cles" name="mots_cles" value="<?php
 echo $categorie_actuelle['mots_cles'] ?? '';  ?>"><br><br>

 <input type="submit" name="" class="btn" value="Valider"><br><br>
 </form>


 <?php
 endif;

 require_once ('../inc/bas.inc.php');

  ?>
