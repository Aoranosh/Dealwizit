<?php

require_once ('inc/init.inc.php');

//--------------TRAITEMENT---------------
//2 Ajout d'un produit au panier :
// var_dump($_POST);

if (isset($_POST['ajout_panier'])) {
  $resultat = executeRequete("SELECT * FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_POST['id_produit']));
  $produit = $resultat->fetch(PDO::FETCH_ASSOC); //pas de while car on a qu'un seul produit dans la requete

  ajouterProduitDansPanier($produit['titre'],$produit['id_produit'],$_POST['quantite'],$produit['prix']);
  //le prix vient de la BDD pour éviter qu'il soit modifiable par l'internaute

  //6- Notification de confirmation d'ajout du panier
  header('location:fiche_produit.php?statut_produit=ajoute&id_produit=' . $produit['id_produit']);
  //on envoie à fiche_produit.php l'info en GET que le produit a bien été ajouté au panier (avec son id)
}

//3- Vider le panier
  if (isset($_GET['action']) && $_GET['action'] == 'vider') {
    // si l'indice action est dans l'url et que sa valeur est vidé on supprime le panier
    unset($_SESSION['panier']);//on supprime le panier de session
  }

//4 - supprimer un article du panier :
if (isset($_GET['action']) && $_GET['action'] == 'supprimer_article' && isset($_GET['articleASupprimer'])){
  //si on a action=supprimer dans l'url et articleASupprimer, alors on appelle la fonction de suppression
  retirerProduitDuPanier($_GET['articleASupprimer']);

}

//5- validation du panier:
if (isset($_POST['valider'])) {
  //si on a cliqué sur le bouton valider du panier :
  $id_membre =
  $montant_total = montantTotal(); //on appelle la fonction qui calcule le total du pannier

  //on insère la commande en BDD
  executeRequete("INSERT INTO commande (id_membre, montant, date_enregistrement)VALUES('$id_membre','$montant_total',NOW())");

  //on récupére l'id de la commande précédmment insérée :
  $id_commande =$pdo->lastInsertId();//info nécessaire pour la table details_commande

  //puis on insère les infos dans la table details_commande
  for ($i=0; $i < count($_SESSION['panier']['id']); $i++) {
    $id_produit = $_SESSION['panier']['id'][$i];
    $quantite = $_SESSION['panier']['quantite'][$i];
    $prix = $_SESSION['panier']['prix'][$i];

    executeRequete("INSERT INTO details_commande (id_commande, id_produit, quantite, prix)VALUES('$id_commande','$id_produit','$quantite','$prix')");

    //décrémenter le stock de chaque article
    executeRequete("UPDATE produit SET stock = stock - '$quantite' WHERE id_produit = '$id_produit'");

  }//fin du for

//suppression finale du Panier
unset($_SESSION['panier']);

$contenu .= '<div class="bg-success">Merci pour votre commande. Votre numéro de suivi est le '. $id_commande .'</div>';

} //fin du if (isset($_POST['valider']))



 ?>



<?php
require_once ('inc/haut.inc.php');
echo $contenu;

//1- affichage du Panier en front
echo '<h2>Voici votre panier</h2>';

if (empty($_SESSION['panier']['id_produit'])) {
  //le panier est vide :
  echo '<p>Vous n avez pas fait de demande.</p>';
} else {
  //le panier n'est pas vide, on l'affiche :
  echo '<table class="table">';
  echo '<tr class="info">
        <th>Titre</th>
        <th>Référence</th>
        <th>Quantité</th>
        <th>Prix unitaire</th>
        <th>Action</th>
        </tr>';//on crée la fonction en deux temps, d'abord les entetes du tableau puis la fonction de panier

  //les lignes de chaque de produits
  for ($i=0; $i < count($_SESSION['panier']['id_produit']); $i++) { //on créée une boucle pour afficher la liste des produits en panier
    //on va utiliser le count() et/ou sizeof() pour déterminer la longueur de la boucle
    //on fait autant de tour de boucle qu'il ya d'id_produit dans panier
    echo '<tr>';
      echo '<td>'. $_SESSION['panier']['titre'][$i] .'</td>';
      echo '<td>'. $_SESSION['panier']['id_produit'][$i] .'</td>';
      echo '<td>'. $_SESSION['panier']['quantite'][$i] .' ex</td>';
      echo '<td>'. $_SESSION['panier']['prix'][$i] .' €</td>';
      echo '<td><a href="?action=supprimer_article&articleASupprimer='. $_SESSION['panier']['id_produit'][$i] .'">Supprimer l\'article</a></td>';

    echo '</tr>';
  }
  //la ligne du total :
  echo '<tr class="info">
        <th colspan="3">Total<th>
        <th colspan="2">'. montantTotal() .' €<th>
        </tr>';

  //ligne du bouton de validation du panier :
  if (internauteEstConnecte()) {
    //si membre connecté alors on affiche le bouton de validation:
    echo '<tr class="text-center">
      <td colspan="5">
        <form method="post" action="">
          <input type="submit" name="valider" value="valider le panier" class="btn">
        </form>
      </td>
    </tr>';
  }else {
    //sinon on l'invite à s'inscrire ou se connecter :
    echo '<tr class="text-center">
      <td colspan="5">
       Veuillez vous <a href="inscription.php">inscrire</a> ou vous <a href="connexion.php">connecter</a> afin de pouvoir valider le panier
      </td>
    </tr>';
  }
  //lien pour vider mon panier
  echo '<tr class="text-center">
    <td colspan="5">
      <a href="?action=vider">Vider mon panier</a>
    </td>
  </tr>';

  echo '</table>';
}//fin du if (empty($_SESSION['panier']['id_produit']))


require_once ('inc/bas.inc.php');

 ?>
