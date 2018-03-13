<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

	<title>Ma Boutique</title>

    <link rel="stylesheet" href="<?php echo RACINE_SITE . 'inc/css/bootstrap.min.css'?>">
    <link rel="stylesheet" href="<?php echo RACINE_SITE . 'inc/css/shop-homepage.css'?>">
    <link rel="stylesheet" href="<?php echo RACINE_SITE . 'inc/css/portfolio-item.css'?>">
    <script src="<?php //echo RACINE_SITE . 'inc/js/jquery.min.js' ?>"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script>
    function fill1(Value) {
       $('#search').val(Value);
       $('#display').hide();
    }
    function fill2(Value) {

       $('#id_annonce').val(Value);

      $(location).attr('href','fiche_annonce.php?id='+$('#id_annonce').val());

/*
         $.ajax({
           //AJAX type is "Post".
           type: "POST",
           //Data will be sent to "ajax.php".
           url: "../dealwizit/ajax.php",
           //Data, that will be sent to "ajax.php".
           data: {
               //Assigning value of "name" into "search" variable.
               search: $('#id_annonce').val(),
               action: 'cherche_id'
           },
           //If result found, this funtion will be called.
           success: function(html) {
               //Assigning result to "display" div in "search.php" file.
               $(".resultat").html(html).show();
           }
       });
*/

    }
    $(document).ready(function() {

       $("#search").keyup(function() {
           var titre = $('#search').val();
           if (titre == "") {$("#display").html("");}

           else {
               $.ajax({
                   type: "POST",
                   url: "../dealwizit/ajax.php",
                   data: {
                       search: titre,
                       action : ''
                   },
                   success: function(html) {
                       $("#display").html(html).show();
                   }
               });
           }
       });

    });
    </script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo RACINE_SITE . 'inc/js/bootstrap.min.js' ?>"></script>

</head>

<body>
    <?php $donnees = executeRequete("SELECT * FROM annonce");
    ?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header col-sm-10">
        <a class="navbar-brand" href="<?php echo RACINE_SITE . 'index.php'?>">DEALWIZIT</a>
        <?php if (internauteEstConnecte()): ?>
          <form class="navbar-form navbar-left" role="search">
            <div class="form-group ">
              <input type="text" id="search" class="form-control" action="../dealwizit/fiche_annonce.php" placeholder="J'ai de la chance !">
              <div id="display"></div>
            </div>
            <input type="hidden" id="id_annonce">
            <!-- <button type="submit" class="btn btn-default"><a href="<?php echo RACINE_SITE . 'fiche_annonce.php?id='. $annonce['id'] .''?>">Submit</a></button> -->
          </form>

        <?php endif; ?>

       <button class="dropdown btn" style="float:right;">
         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu<span class="caret"></span></a>
                <ul class="dropdown-menu">

<?php
echo '<li><a href="'. RACINE_SITE .'index.php">Accueil</a></li>';

if (internauteEstConnecte()){
  echo '<li><a href="'. RACINE_SITE .'profil.php">Profil</a></li>';
  echo '<li><a href="'. RACINE_SITE .'contact.php">Contact</a></li>';

  // echo '<li><a href="'. RACINE_SITE .'admin/gestion_annonces.php?action=affichage">Annonces</a></li>';
} else { //visiteur non connecté:
  echo '<li><a href="'. RACINE_SITE .'inscription.php">Inscription</a></li>';
  echo '<li><a href="'. RACINE_SITE .'connexion.php">Connexion</a></li>';
}

if (internauteEstConnecteEtEstAdmin()) {
  //lien vers le back
  // echo '<br><br><h5>Gestionnaire du site</h5>';
  // echo '<li><a href="'. RACINE_SITE .'admin/gestion_index.php">Gestion de la boutique</a></li>';
  echo '<li><a href="'. RACINE_SITE .'admin/gestion_annonces.php?action=affichage">Annonces</a></li>';
  echo '<li><a href="'. RACINE_SITE .'admin/gestion_categories.php?action=affichage">Catégories</a></li>';
  echo '<li><a href="'. RACINE_SITE .'admin/gestion_membres.php?action=affichage">Membres</a></li>';
  echo '<li><a href="'. RACINE_SITE .'admin/gestion_commentaires.php?action=affichage">Commentaires</a></li>';
  echo '<li><a href="'. RACINE_SITE .'admin/gestion_notes.php?action=affichage">Notes</a></li>';
  echo '<li><a href="'. RACINE_SITE .'admin/gestion_statistiques.php?action=affichage">Statistiques</a></li>';
}

if (internauteEstConnecte()){
  echo '<li><a href="'. RACINE_SITE .'connexion.php?action=deconnexion">Se déconnecter</a></li>'; //a la déco, nous avons une action à valeur de deconnexion
}

 ?>
                </ul>
                </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            </div>
        </div>
    </nav><br>
    <div class="container" style="min-height: 80vh; width: 80%;">
