<?php
require_once('../inc/init.inc.php');

if (!internauteEstConnecteEtEstAdmin()) {
    header('location:../connexion.php');
    exit();
  }
//  var_dump($_SESSION['membre']);

 if (isset($_GET['action']) && $_GET['action'] == 'suppression' && isset($_GET['id'])) {
   $resultat = executeRequete("SELECT * FROM commentaire WHERE id = :id", array(':id' => $_GET['id'] ));

   if ($resultat->rowCount() == 1) {
     executeRequete("DELETE FROM commentaire WHERE id = :id", array(':id' => $_GET['id']));

     $contenu .= '<div class ="bg-success">Le commentaire a bien été supprimé ! </div>';
   }else {
     $contenu .= '<div class ="bg-warning">Le commentaire n\'existe pas !</div>';
   }
   $_GET['action'] = 'affichage';
 }

 if ($_POST) {


if(!empty($_POST['id'])){
   executeRequete("REPLACE INTO commentaire (commentaire, membre_id, categorie_id, date_enregistrement) VALUES (:commentaire, :membre_id, :categorie_id, NOW())", array(
     ':id'   => $_POST['id'],
     ':commentaire'    => $_POST['commentaire'],
     ':membre_id'  => $_SESSION['membre']['id'],
     ':categorie_id'    => $_POST['categorie_id'],
     )
  );
} else{
  executeRequete("INSERT INTO commentaire (commentaire, membre_id, categorie_id, date_enregistrement) VALUES (:commentaire, :membre_id, :categorie_id, NOW())", array(
    //':id'   => $_POST['id'],
    ':commentaire'    => $_POST['commentaire'],
    ':membre_id'  => $_SESSION['membre']['id'],
    ':categorie_id'    => $_POST['id'],
    )
  );
}
//var_dump($_POST);
 $contenu .= '<div class="bg-success">Le commentaire a été enregistré ! </div><br><br>';

 $_GET['action'] = 'affichage';

 }//fin du if


 if (isset($_GET['action']) && $_GET['action'] == 'affichage') {

   $resultat = executeRequete("SELECT * FROM commentaire");

   $contenu .= '<br>Nombre de commentaires dans la boutique : ' . $resultat->rowCount();

   $contenu .= '<table class="table">';
     $contenu .= '<tr>';
       $contenu .= '<th>Id</th>';
       $contenu .= '<th>Commentaire</th>';
       $contenu .= '<th>Membre Id</th>';
       $contenu .= '<th>Annonce Id</th>';
       $contenu .= '<th>Date Enregistrement</th>';
       $contenu .= '<th>Actions</th>';
     $contenu .= '</tr>';

   while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
     //var_dump($ligne); //$ligne est un array associatif avec le nom des champs de la table commentaire en indice

     $contenu .= '<tr>';
     foreach ($ligne as $indice => $information) {
       if ($indice == 'photo') {
           $contenu .= '<td><img src ="'. $information .'" width="90" height="70"></td>';
       }else{
         $contenu .= '<td>'. $information .'</td>';

       }

     }
     $contenu .= '<td>
                   <a href="?action=modification&id='. $ligne['id'] .'"><button type="button" class="btn btn-primary"> Modifier </button></a>
                   <a href="?action=suppression&id='. $ligne['id'] .'" onclick="return(confirm(\'Etes-vous sûr de vouloir de supprimer cette annonce ?\'))" ><button type="button" class="btn btn-danger">Supprimer</button></a>
                 </td>';
     $contenu .= '</tr>';
   }

   $contenu .= '</table>';
 }


 //affichage-----------------------------------------------------
 require_once ('adminhaut.inc.php');
 echo '<ul class="nav nav-tabs">
       <li><a href="?action=affichage">Affichage des commentaires</a></li>
       <ul>';
       // <li><a href="?action=ajout">Ajout d\'un commentaire</a></li>

 echo $contenu;


 if (isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')) :

 if (isset($_GET['id'])) {

     $resultat = executeRequete("SELECT * FROM commentaire WHERE id = :id", array(":id" => $_GET['id']));
     $commentaire_actuel = $resultat->fetch(PDO::FETCH_ASSOC);

 }

   ?>

 <br><br><h4>Formulaire d'ajout ou de modification des commentaires</h4>
 <form enctype="multipart/form-data" action="" method="post">
 <input type="hidden" id="id" name="id" value="<?php
 echo $commentaire_actuel['id'] ?? '';  ?>"><br><br>

 <label for="commentaire">commentaire</label><br>
 <input type="text" id="commentaire" name="commentaire" value="<?php
 echo $commentaire_actuel['commentaire'] ?? '';  ?>"><br><br>


 <input type="submit" name="" class="btn" value="Valider"><br><br>
 </form>


 <?php
 endif;

 if (internauteEstConnecteEtEstAdmin()) {
   require_once ('bas.admin.inc.php');
 } else {
   require_once ('../inc/bas.inc.php');
 }

  ?>
