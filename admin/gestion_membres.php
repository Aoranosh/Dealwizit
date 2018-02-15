<?php
require_once('../inc/init.inc.php');

if (!internauteEstConnecteEtEstAdmin()) {
    header('location:../connexion.php');
    exit();
  }
  //var_dump($_SESSION['membre']);

 if (isset($_GET['action']) && $_GET['action'] == 'suppression' && isset($_GET['id'])) {
   $resultat = executeRequete("SELECT * FROM membre WHERE id = :id", array(':id' => $_GET['id'] ));

   if ($resultat->rowCount() == 1) {
     executeRequete("DELETE FROM membre WHERE id = :id", array(':id' => $_GET['id']));

     $contenu .= '<div class ="bg-success">Le membre a bien été supprimé ! </div>';
   }else {
     $contenu .= '<div class ="bg-warning">Le membre n\'existe pas ! </div>';
   }
   $_GET['action'] = 'affichage';
 }

 if ($_POST) {

  if(!empty($_POST['id'])){

   executeRequete("REPLACE INTO membre (pseudo, mdp, nom, prenom, email, telephone, civilite, role, date_enregistrement) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :telephone, :civilite, :role, NOW())", array(
    // ':id'   => $_POST['id'],
     ':mdp'=> $_POST['mdp'],
     ':pseudo'    => $_POST['pseudo'],
     ':nom'  => $_POST['nom'],
     ':prenom'         => $_POST['prenom'],
     ':email'      => $_POST['email'],
     ':telephone'       => $_POST['telephone'],
     ':civilite'       => $_POST['civilite'],
     ':role'       => $_POST['role'],
     ));
  } else {

   executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, telephone, civilite, role, date_enregistrement) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :telephone, :civilite, :role, NOW())", array(
     // ':id'   => $_POST['id'],
     ':pseudo'    => $_POST['pseudo'],
     ':mdp'=> $_POST['mdp'],
     ':nom'  => $_POST['nom'],
     ':prenom'         => $_POST['prenom'],
     ':email'      => $_POST['email'],
     ':telephone'       => $_POST['telephone'],
     ':civilite'       => $_POST['civilite'],
     ':role'       => $_POST['role'],
     ));
  }
  //var_dump($_POST);
 $contenu .= '<div class="bg-success">Le membre a été enregistré ! </div><br>';

 $_GET['action'] = 'affichage';

 }//fin du if


 if (isset($_GET['action']) && $_GET['action'] == 'affichage') {

   $resultat = executeRequete("SELECT id, pseudo, prenom, email, telephone, civilite, role, date_enregistrement FROM membre");

   $contenu .= 'Nombre de membres dans la boutique : ' . $resultat->rowCount();

   $contenu .= '<table class="table">';
     $contenu .= '<tr>';
       $contenu .= '<th>Id</th>';
       $contenu .= '<th>Pseudo</th>';
       $contenu .= '<th>Prenom</th>';
       $contenu .= '<th>Email</th>';
       $contenu .= '<th>Telephone</th>';
       $contenu .= '<th>Civilite</th>';
       $contenu .= '<th>Statut</th>';
       $contenu .= '<th>Date enregistrement</th>';
       $contenu .= '<th>Actions</th>';
     $contenu .= '</tr>';

while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
  $contenu .= '<tr>';
  foreach ($ligne as $indice => $information) {

        $contenu .= '<td>'. $information .'</td>';

    }

     $contenu .= '<td>
                   <a href="?action=modification&id='. $ligne['id'] .'">modifier</a>
                   /
                   <a href="?action=suppression&id='. $ligne['id'] .'" onclick="return(confirm(\'Etes-vous sûr de vouloir de supprimer cette membre ?\'))" >supprimer</a>
                 </td>';
     $contenu .= '</tr>';
   }
   $contenu .= '</table>';
}

 //affichage-----------------------------------------------------
 require_once ('adminhaut.inc.php');
 echo '<ul class="nav nav-tabs">
       <li><a href="?action=affichage">Affichage des membres</a></li>
       <li><a href="?action=ajout">Ajout d\'un membre</a></li>
       <ul>';

 echo $contenu;


 if (isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')) :
   $resultat = executeRequete("SELECT * FROM categorie");
  $toutescategories = '<select name="id">';


 if (isset($_GET['id'])) {

     $resultat = executeRequete("SELECT * FROM membre WHERE id = :id", array(":id" => $_GET['id']));
     $membre_actuel = $resultat->fetch(PDO::FETCH_ASSOC);

 }

   ?>

 <br><h4>Formulaire d'ajout ou de modification des membres</h4>
 <form enctype="multipart/form-data" action="" method="post">
 <input type="hidden" id="id" name="id" value="<?php
 echo $membre_actuel['id'] ?? '';  ?>"><br>

 <label for="pseudo">Pseudo</label><br>
 <input type="text" id="pseudo" name="pseudo" value="<?php
 echo $membre_actuel['pseudo'] ?? '';  ?>"><br><br>

 <label for="mdp">Mot de passe</label><br>
 <input type="password" id="mdp" name="mdp" value="<?php
 echo $membre_actuel['mdp'] ?? '';  ?>"><br><br>

 <label for="nom">Nom</label><br>
 <input type="text" id="nom" name="nom" value="<?php
 echo $membre_actuel['nom'] ?? '';  ?>"><br><br>

 <label for="prenom">Prenom</label><br>
 <input type="text" id="prenom" name="prenom" value="<?php
 echo $membre_actuel['prenom'] ?? '';  ?>"><br><br>

 <label for="email">Email</label><br>
 <input type="text" id="email" name="email" value="<?php
 echo $membre_actuel['email'] ?? '';  ?>"><br><br>

 <label for="telephone">Telephone</label><br>
 <input type="text" id="telephone" name="telephone" value="<?php
 echo $membre_actuel['telephone'] ?? '';  ?>"><br><br>

 <label for="civilite">Civilité</label><br>
 <input type="radio" id="civilite" name="civilite" value="M" checked>
 <label for="civilite">M</label>
 <input type="radio" id="civilite" name="civilite" value="Mme">
 <label for="civilite">Mme</label><br><br>

 <label for="role">Statut</label><br>
 <input type="radio" id="role" name="role" value="user" checked>
 <label for="role">User</label>
 <input type="radio" id="role" name="role" value="admin">
 <label for="role">Admin</label>
 <br><br>

 <!-- <label for="membre_id">Membre</label><br>
 <input type="text" id="membre_id" name="membre_id" value="<?//php
 //echo $membre_actuel['membre_id'] ?? '';  ?>"><br><br> -->

 <!-- <input type="text" id="categorie_id" name="categorie_id" value="<?php
 //echo $membre_actuel['categorie_id'] ?? '';  ?>"><br><br> -->


 <input type="submit" name="" class="btn" value="Valider"><br><br>
 </form>


 <?php
 endif;

 require_once ('../inc/bas.inc.php');

  ?>
