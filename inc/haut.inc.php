<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

	<title>Ma Boutique</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="<?php echo RACINE_SITE . 'inc/css/bootstrap.min.css'?>">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo RACINE_SITE . 'inc/css/shop-homepage.css'?>">
  	<!-- AJOUTER LE LIEN CSS SUIVANT POUR LE DETAIL PRODUIT-->
    <link rel="stylesheet" href="<?php echo RACINE_SITE . 'inc/css/portfolio-item.css'?>">
  	<!-- jQuery -->
    <script src="<?php echo RACINE_SITE . 'inc/js/jquery.js' ?>"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo RACINE_SITE . 'inc/js/bootstrap.min.js' ?>"></script>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">

			<!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">

				<!-- <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button> -->
				<!-- La marque -->
        <a class="navbar-brand" href="<?php echo RACINE_SITE . 'boutique.php'?>">DEALWIZIT</a>

		   </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                 	<!-- le menu de navigation -->
<?php
echo '<li><a href="'. RACINE_SITE .'boutique.php">Accueil</a></li>';

if (internauteEstConnecte()){
  echo '<li><a href="'. RACINE_SITE .'panier.php">Demande en cours</a></li>';
  echo '<li><a href="'. RACINE_SITE .'profil.php">Profil</a></li>';
  echo '<li><a href="'. RACINE_SITE .'connexion.php?action=deconnexion">Se déconnecter</a></li>'; //a la déco, nous avons une action à valeur de deconnexion
  echo '<li><a href="'. RACINE_SITE .'admin/gestion_annonces.php">Annonces</a></li>';
} else { //visiteur non connecté:
  echo '<li><a href="'. RACINE_SITE .'inscription.php">Inscription</a></li>';
  echo '<li><a href="'. RACINE_SITE .'connexion.php">Connexion</a></li>';
}

if (internauteEstConnecteEtEstAdmin()) {
  //lien vers le back
  // echo '<br><br><h5>Gestionnaire du site</h5>';
  // echo '<li><a href="'. RACINE_SITE .'admin/gestion_boutique.php">Gestion de la boutique</a></li>';
  echo '<li><a href="'. RACINE_SITE .'admin/gestion_annonces.php">Annonces</a></li>';
  echo '<li><a href="'. RACINE_SITE .'admin/gestion_categories.php">Catégories</a></li>';
  echo '<li><a href="'. RACINE_SITE .'admin/gestion_membres.php">Membres</a></li>';
  echo '<li><a href="'. RACINE_SITE .'admin/gestion_commentaires.php">Commentaires</a></li>';
  echo '<li><a href="'. RACINE_SITE .'admin/gestion_notes.php">Notes</a></li>';
  echo '<li><a href="'. RACINE_SITE .'admin/gestion_statistiques.php">Statistiques</a></li>';
}




 ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div> <!-- /.container -->
    </nav><br>
    <!-- Page Content -->
    <div class="container" style="min-height: 80vh;">
