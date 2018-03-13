<?php

require_once ('inc/init.inc.php');

//------------------TRAITEMENT-----------------
$resultat = executeRequete("SELECT * FROM categorie");

$contenu_gauche .='<p class="lead">Les annonces</p>';
if(!internauteEstConnecteEtEstAdmin() && internauteEstConnecte()){
$contenu_gauche .='<div><a href="/portfolio/dealwizit/admin/gestion_annonces.php?action=ajout"><button type="button" class="btn btn-primary" name="button">Ajouter une annonce</button></a></div>';
$contenu_gauche .= '<br><br>';
}
$contenu_gauche .='<div class="list-group">';
$contenu_gauche .= '<label for="list-cat">Catégories</label>';
  $contenu_gauche .='<a href= "?categorie=all" class="list-group-item">Tous</a>';

  while($cat = $resultat->fetch(PDO::FETCH_ASSOC)){
    $contenu_gauche .= '<a href="?categorie_id='. $cat['id'] .'" class="list-group-item">'. $cat['titre'] .'</a>';
  }
$contenu_gauche .='</div>';

if (isset($_GET['categorie_id']) && $_GET['categorie_id'] != 'all') {
    $donnees = executeRequete("SELECT * FROM annonce WHERE categorie_id = :categorie_id", array(':categorie_id' => $_GET['categorie_id']));
} else {
    $donnees = executeRequete("SELECT * FROM annonce");
}

while ($annonce = $donnees->fetch(PDO::FETCH_ASSOC)) {
  $contenu_droite .= '<div class="col-sm-4">';
    $contenu_droite .= '<div class="thumbnail">';
      $contenu_droite .= '<a href="fiche_annonce.php?id='. $annonce['id'] .'"><img src="../'. $annonce['photo'] .'"style="width:280px; height:250px;" alt="'. $annonce['titre'] .'"></a>';

      $contenu_droite .= '<div class="caption">';
      $contenu_droite .= '<h4>'. $annonce['titre'] .'<h4>';
      $contenu_droite .= '<p style="font-size:14px">'. $annonce['description_courte'] .'</p>';
        $contenu_droite .= '<h4 class="pull-right">'. $annonce['prix'] .'€<h4>';

      $contenu_droite .= '</div>';
    $contenu_droite .= '</div>';
  $contenu_droite .= '</div>';

}
//------------------AFFICHAGE------------------
require_once ('inc/haut.inc.php');
?>
<div class="headerAjout">

</div>
  <div class="row">
      <div class="col-md-3">
          <?php  echo $contenu_gauche; ?>
      </div>
      <div class="col-md-9 resultat">
        <h2>Annonces : <?php echo $cat['titre'];?></h2>
          <div class="row">
            <?php  echo $contenu_droite; ?>
          </div>
      </div>
  </div>


<?php
require_once ('inc/bas.inc.php');



 ?>
