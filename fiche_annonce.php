<?php

require_once ('inc/init.inc.php');
//$panier = '';
$suggestion = '';
$categorie = '';

//1- Vérifier l'existence du annonce demandé :
if (isset($_GET['id'])) {
  //on vérifie que le annonce existe tjr en BDD
  $resultat = executeRequete("SELECT * FROM annonce WHERE id = :id", array(':id' => $_GET['id']));
  if ($resultat->rowCount() == 0) {
    //s'il n'y a pas de annonce dans la BDD, on renvoie vers la boutique
    header('location:boutique.php');
    exit();
  }

  //2- Mise en forme des infos du annonce:
  $annonce = $resultat->fetch(PDO::FETCH_ASSOC);
  // var_dump($annonce);
  extract($annonce); //va extraire chaque indice de l'array et créer des variables nommées comme les indices de l'array et qui prennent leur valeur
  //3- Affichage du formulaire d'ajout au panier si stock > 0 :
  // if ($stock > 0) {
  //   //on ajoute le bouton de panier
  //   //$panier .= '<form method="post" action="panier.php">'; //dans le panier il nous faut id_annonce / quantité / bouton
  //     //$panier .= '<input type ="hidden" name="id" value="'. $id .'">';
  //     //selecteur de quantité de annonce
  //
  //     //$panier .= '<select name ="quantite">';
  //         for ($i=1; $i <= $stock && $i <= 10; $i++) {
  //           //$panier .= "<option>$i</option>";
  //         }
  //     //$panier .= '</select>';
  //     //bouton d'ajout au panier :
  //     //$panier .= '<input type ="submit" name="ajout_panier" value="ajouter au panier" class="btn">';
  //   //$panier .= '</form>';
  //   //$panier .= '<p>Nombre de annonces disponibles : '. $stock .'</p>';
  // }else {
  //   //$panier .= '<p>Victime de son succès !</p>';
  // }

}else {
  header('location:boutique.php'); //si aucun annonce demandé, on oriente vers la boutique

  exit();
}

//4-Affichage du modal de confirmation d'ajout au panier

if (isset($_GET['statut_annonce']) && $_GET['statut_annonce'] == 'ajoute') {
  //on reçoit l'info que le annonce a bien été ajouté
  //var_dump($_GET);
  $contenu_gauche .= '<div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Le annonce a bien été ajouté au panier</h4>
                          </div>

                          <div class="modal-body">
                            <p><a href="panier.php">Voir le panier</a></p>
                            <p><a href="boutique.php">Continuer vos achats</a></p>
                          </div>
                          </div>
                        </div>
                      </div>';
}

//-------------------------------

// $requete = executeRequete("SELECT id, titre, photo FROM annonce WHERE categorie_id = id <> '$annonce[id]' ORDER BY RAND() LIMIT 0,2");

$requete = executeRequete("SELECT id, titre, prix, adresse, code_postal, ville, photo, date_enregistrement FROM annonce WHERE categorie_id = '$annonce[categorie_id]' AND id <> '$annonce[id]' ORDER BY RAND() LIMIT 0,4");

//affichage des annonces suggérés :
while ($autres_annonces = $requete->fetch(PDO::FETCH_ASSOC)){
  $suggestion .='<div class="col-sm-3">';
  $suggestion .='<div class="thumbnail">';
    $suggestion .='<a href="?id='. $autres_annonces['id'] .'">
                  <img src="'. $autres_annonces['photo'] .'" alt="" style="width:50%; height:50%;">
                  </a>';
    $suggestion .='<h4>'. $autres_annonces['titre'] .'</h4>';
    $suggestion .='<p>'. $autres_annonces['prix'] .'€</p>';

  $suggestion .='</div>';
  $suggestion .='</div>';
}
// if (internauteEstConnecteEtEstAdmin()) {
//   require_once('admin/adminhaut.inc.php');
// }else {
// }
require_once('inc/haut.inc.php');

echo $contenu_gauche; //contiendra le pop-up de confirmation d'ajout du panie


?>
<!-- affichage détaillé du annonce -->
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $titre; ?></h1>
        <a href="boutique.php?categorie_id=<?php echo $categorie_id; ?>">Retour vers la catégorie sélectionnée</a>
  </div>
  <div class="col-md-8">
    <img class="img-responsive" src="<?php echo $photo;?>" alt="">
  </div>
  <div class="col-md-4">
    <h3>Description courte</h3>
    <p><?php echo $description_courte; ?></p>
    <h3>Détails</h3>
    <ul style="list-style-type:none;">
      <li>Catégorie: <?php echo $categorie_id; ?></li>
      <li>Description longue: <?php echo $description_longue; ?></li>
      <li>Adresse: <?php echo $adresse.', '.$code_postal.' '.$ville; ?></li>
    </ul>
    <p class="lead">Prix : <?php echo $prix; ?> €</p>


  </div>
</div>

<!-- EXERCICE -->
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">Suggestion du annonces</h3>
  </div>
  <?php echo $suggestion; ?>
</div>

<script>
  $(function(){
    $("#myModal").modal("show");
  });
</script>


<?php
require_once ('inc/bas.inc.php');

 ?>
