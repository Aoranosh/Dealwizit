<?php
require_once('../inc/init.inc.php');

if (!internauteEstConnecteEtEstAdmin()) {
    header('location:../connexion.php');
    exit();
  }
//  var_dump($_SESSION['membre']);

 if (isset($_GET['action']) && $_GET['action'] == 'suppression' && isset($_GET['id'])) {
   $resultat = executeRequete("SELECT * FROM note WHERE id = :id", array(':id' => $_GET['id'] ));

   if ($resultat->rowCount() == 1) {
     executeRequete("DELETE FROM note WHERE id = :id", array(':id' => $_GET['id']));

     $contenu .= '<div class ="bg-success">La note a bien été supprimé ! </div>';
   }else {
     $contenu .= '<div class ="bg-warning">La note n\'existe pas !</div>';
   }
   $_GET['action'] = 'affichage';
 }

 if ($_POST) {


if(!empty($_POST['id'])){
   executeRequete("REPLACE INTO note (note, avis, membre_id1, membre_id2, date_enregistrement) VALUES (:note, :avis, :membre_id1, :membre_id2, NOW())", array(
     //':id'   => $_POST['id'],
     ':note'    => $_POST['note'],
     ':note'    => $_POST['avis'],
     ':membre_id1'  => $_SESSION['membre']['id'],
     ':membre_id2'    => $_POST['membre_id2'],
     )
  );
} else{
  executeRequete("INSERT INTO note (note, avis, membre_id1, membre_id2, date_enregistrement) VALUES (:note, :avis, :membre_id1, :membre_id2, NOW())", array(
    //':id'   => $_POST['id'],
    ':note'    => $_POST['note'],
    ':note'    => $_POST['avis'],
    ':membre_id1'  => $_SESSION['membre']['id'],
    ':membre_id2'    => $_POST['membre_id2'],
    )
  );
}
//var_dump($_POST);
 $contenu .= '<div class="bg-success">La note a été enregistrée ! </div><br><br>';

 $_GET['action'] = 'affichage';

 }//fin du if


 if (isset($_GET['action']) && $_GET['action'] == 'affichage') {

   $resultat = executeRequete("SELECT * FROM note");

   $contenu .= '<br>Nombre de notes dans la boutique : ' . $resultat->rowCount();

   $contenu .= '<table class="table">';
     $contenu .= '<tr>';
       $contenu .= '<th>Id</th>';
       $contenu .= '<th>Note</th>';
       $contenu .= '<th>Avis</th>';
       $contenu .= '<th>Membre 1</th>';
       $contenu .= '<th>Membre 2</th>';
       $contenu .= '<th>Date Enregistrement</th>';
       $contenu .= '<th>Actions</th>';
     $contenu .= '</tr>';

   while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
     //var_dump($ligne); //$ligne est un array associatif avec le nom des champs de la table note en indice

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
       <li><a href="?action=affichage">Affichage des notes</a></li>
       <ul>';
       //<li><a href="?action=ajout">Ajout d\'une note</a></li>

 echo $contenu;


 if (isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')) :

 if (isset($_GET['id'])) {

     $resultat = executeRequete("SELECT * FROM note WHERE id = :id", array(":id" => $_GET['id']));
     $note_actuel = $resultat->fetch(PDO::FETCH_ASSOC);

 }

   ?>

 <br><br><h4>Formulaire d'ajout ou de modification des notes</h4>
 <form enctype="multipart/form-data" action="" method="post">
 <input type="hidden" id="id" name="id" value="<?php
 echo $note_actuel['id'] ?? '';  ?>"><br><br>

 <label for="note">note</label><br>
 <input type="text" id="note" name="note" value="<?php
 echo $note_actuel['note'] ?? '';  ?>"><br><br>


 <input type="submit" name="" class="btn" value="Valider"><br><br>
 </form>


 <?php
 endif;

 require_once ('../inc/bas.inc.php');

  ?>
