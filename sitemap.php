<?php require_once ('inc/int.inc.php'); ?>

<?php require_once ('inc/haut.inc.php'); ?>
<h2>Pages Utilisateur</h2>
<ol class="breadcrumb">
  <li><a href="inscription.php">Inscription</a></li>
  <li><a href="connexion.php">Connexion</a></li>
  <li><a href="profil.php">Profil</a></li>
  <li><a href="contact.php">Contact</a></li>
</ol>
<ol class="breadcrumb">
  <li><a href="index.php">Accueil</a></li>
  <li><a href="legalNotice.html">Mentions Légales</a></li>
  <li><a href="cgu.html">C.G.U.</a></li>
  <li class="active">Plan du site</li>
</ol>';
<?php if (internauteEstConnecte()) {
  echo '<h2>Pages Adminitrateur</h2>';
  echo '<ol class="breadcrumb">
  <li><a href="admin/gestion_annonces.php?action=afficher">Gestion Annonces</a></li>
  <li><a href="admin/gestion_membres.php?action=afficher">Gestion Membres</a></li>
  <li><a href="admin/gestion_categories.php?action=afficher">Gestion Catégories</a></li>
  <li><a href="admin/gestion_commentaires.php?action=afficher">Gestion Commentaires</a></li>
  <li><a href="admin/gestion_notes.php?action=afficher">Gestion Notes</a></li>
</ol>';

} ?>
<?php require_once ('inc/bas.inc.php'); ?>
