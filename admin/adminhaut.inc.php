<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DEALWIZIT</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script>
    function fill1(Value) {
       $('#search').val(Value);
       $('#display').hide();
    }
    function fill2(Value) {

       $('#id_annonce').val(Value);

      $(location).attr('href','fiche_annonce.php?id='+$('#id_annonce').val());
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

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="../index.php">ADMINISTRATION DEALWIZIT</a>
            </div>
            <!-- /.navbar-header -->
                    <button class="dropdown btn">
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
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <?php if (internauteEstConnecte()): ?>
                                  <form class="navbar-form navbar-left" role="search">
                                    <div class="form-group ">
                                      <input type="text" id="search" class="form-control" action="../dealwizit/fiche_annonce.php" placeholder="Search">
                                    </div>
                                    <input type="hidden" id="id_annonce">
                                    <!-- <button type="submit" class="btn btn-default"><a href="<?php echo RACINE_SITE . 'fiche_annonce.php?id='. $annonce['id'] .''?>">Submit</a></button> -->
                                  </form>

                                <?php endif; ?>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                        <div id="display"></div>
                        </li>
                        <li>
                            <a href="gestion_annonces.php?action=affichage">Gestion des annonces</a>
                        </li>
                        <li>
                            <a href="gestion_categories.php?action=affichage">Gestion des catégories</a>
                        </li>
                        <li>
                            <a href="gestion_membres.php?action=affichage">Gestion des membres</a>
                        </li>
                        <li>
                            <a href="gestion_commentaires.php?action=affichage">Gestion des commentaires</a>
                        </li>
                        <li>
                            <a href="gestion_notes.php">Gestion des notes</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        <div class="container" style="padding-top: 0;">
          <!-- style="min-height: 80vh; -->
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>
