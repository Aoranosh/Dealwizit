<?php

require_once ('inc/init.inc.php');
//$panier = '';
$suggestion = '';
$categorie = '';
$success = '';

if (!empty($_GET['action']) && $_GET['action'] == 'envoyer'){
    //echo 'Votre commentaire a bien été envoyé !';
    $success .= '<div class="bg-success"><strong>Votre commentaire a bien été envoyé !</strong></div>';
}

// Vérifier l'existence du annonce demandé :
if (isset($_GET['id'])) {
  //on vérifie que le annonce existe tjr en BDD
  $resultat = executeRequete("SELECT * FROM annonce WHERE id = :id", array(':id' => $_GET['id']));
  if ($resultat->rowCount() == 0) {
    //s'il n'y a pas de annonce dans la BDD, on renvoie vers la boutique
    header('location:index.php');
    exit();
  }

  //2- Mise en forme des infos du annonce:
  $annonce = $resultat->fetch(PDO::FETCH_ASSOC);
  // var_dump($annonce);
  extract($annonce);

}else {
  header('location:index.php'); //si aucun annonce demandé, on oriente vers la boutique

  exit();
}

// $requete = executeRequete("SELECT id, titre, photo FROM annonce WHERE categorie_id = id <> '$annonce[id]' ORDER BY RAND() LIMIT 0,2");
//suggestion
$requete = executeRequete("SELECT id, titre, prix, adresse, code_postal, ville, photo, description_courte, date_enregistrement FROM annonce WHERE categorie_id = '$annonce[categorie_id]' AND id <> '$annonce[id]' ORDER BY RAND() LIMIT 0,4");

//affichage des annonces suggérés :
while ($autres_annonces = $requete->fetch(PDO::FETCH_ASSOC)){
  $suggestion .='<div class="col-sm-3">';
  $suggestion .='<div class="thumbnail">';
    $suggestion .='<a href="?id='. $autres_annonces['id'] .'">
                  <img src="/portfolio/'. $autres_annonces['photo'] .'" alt="" style="width:50%; height:50%;">
                  </a>';
    $suggestion .='<h4>'. $autres_annonces['titre'] .'</h4>';
    $suggestion .='<p>'. $autres_annonces['prix'] .'€</p>';

  $suggestion .='</div>';
  $suggestion .='</div>';
}
if (!empty($_POST)) {

    // TRAITEMENT DU POST COMMENTAIRE

    if (!empty($_GET['action']) && $_GET['action'] == 'commentaire') {

        if (empty($_POST['commentaire']) || strlen($_POST['commentaire']) < 20 || strlen($_POST['commentaire']) > 500) {

            $contenu .= '<div class="alert alert-danger"><strong>Votre commentaire est trop court !</strong></div>';
        }

        if (empty($contenu)) {
            // INSERTION EN BASE DE DONNEES

            executeRequete("INSERT INTO commentaire (commentaire, membre_id, annonce_id, date_enregistrement) VALUES(:commentaire, :membre_id, :annonce_id, NOW())", array(
                ':commentaire' => $_POST['commentaire'],
                ':membre_id' => $_SESSION['membre']['id'],
                ':annonce_id' => $id));

            header('location:fiche_annonce.php?id=' . $id . '&action=envoyer');
            exit();
        }
    //fin de if (empty($_POST['commentaire']) || strlen($_POST['commentaire'])
    }
}


// TRAITEMENT ET AFFICHAGE DES COMMENTAIRES

$commentaire = executeRequete("SELECT * FROM commentaire, membre WHERE commentaire.annonce_id = :id AND commentaire.membre_id = membre.id", array(
                ':id' => $_GET['id']));

$affichagecommentaire = $commentaire->fetchAll(PDO::FETCH_ASSOC);

require_once('inc/haut.inc.php');
echo $success;
?>

<!-- affichage détaillé du annonce -->
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $titre; ?></h1>
        <a href="index.php?categorie_id=<?php echo $categorie_id; ?>">Retour vers la catégorie sélectionnée</a>
  </div>
  <div class="col-md-8">
    <img class="img-responsive" src="/portfolio/<?php echo $photo;?>" alt="photo_annonce">
  </div>
  <div class="col-md-4">
    <h3>Description rapide</h3>
    <p><?php echo $description_courte; ?></p>
    <h3>Détails</h3>
    <ul style="list-style-type:none;">
      <li>Catégorie: <?php echo $categorie_id; ?></li>
      <li>Description longue: <?php echo $description_longue; ?></li>
      <li>Adresse: <?php echo $adresse.', '.$code_postal.' '.$ville; ?></li>
      <li>Date de publication : <?php echo $date_enregistrement; ?></li>
      <li>Publié par : <?php echo $membre_id; ?></li>
    </ul>
    <p class="lead">Prix : <?php echo $prix; ?> €</p>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#contactModal">
      Contactez ce membre !
    </button>

  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <h4 class="page-header">Autres annonces qui pourrait vous intéresser</h4>
  </div>
  <?php echo $suggestion; ?>
</div>

<!-- MAPS API -->
<div class="row">

    <div class="col-lg-12">

        <input type="hidden" id="votreadresse" value="<?php echo $adresse.' '.$code_postal ?>">
        <div id="plan" style="height:250px"></div>

    </div>
</div>
<script>
    var initmap = function() {
        var address = document.getElementById("votreadresse").value;

        var map = new google.maps.Map(document.getElementById('plan'), {
            mapTypeId: google.maps.MapTypeId.TERRAIN,
            zoom: 14
        });

        var geocoder = new google.maps.Geocoder();

        geocoder.geocode({
                'address': address
            },
            function(results, status) { //callback

                if (status == google.maps.GeocoderStatus.OK) {

                    new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map
                    });
                    map.setCenter(results[0].geometry.location);
                }
            });
    }

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCJnBG6NKhDIJju9HO6BLrm27dmlsKdug&callback=initmap">


</script>

<!-- AFFICHAGE DETAILLE DE L'ANNONCE -->
<div class="container">

        <div class="col-md-12">
            <h3>Commentaires postés</h3>
        </div>

        <div class="col-md-12">
        <?php foreach($affichagecommentaire as $unCommentaire) : ?>
            <p>
            <?php
            echo 'Commentaire :' . '<br>' . $unCommentaire['commentaire'] . '<br><br>';
            echo 'Pseudo : ' . $unCommentaire['pseudo'] . '<br>';
            echo 'Date : ' . $unCommentaire['date_enregistrement'] . '<hr><br>';
            ?>
            </p>
        <?php endforeach; ?>
        </div>


    </div> <!-- fin de row -->
    <!-- AFFICHAGE DU MODAL COMMENTAIRE/AVIS -->
    <div class="comContainer" style="text-align:center;">
    <h4>Laissez un commentaire</h4>
    <button type="button" class="btn btn-warning" data-toggle="modal" role="dialog" data-target="#comModal">Cliquez pour poster !</button>
  </div><br><br>
    <!-- Modal -->
    <div class="modal fade" id="comModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Commentaires et avis</h4>
                </div>
                <div class="modal-body">
                <?php
                if (!internauteEstConnecte()) {
                    echo  '<a href="connexion.php">Pour laisser un commentaire, merci de vous connecter</a>';
                }else{
                    echo "<a href=\"?id=$id&action=avis\">Déposez un avis</a><br>";
                    echo "<a href=\"?id=$id&action=commentaire\">Déposez un commentaire</a>";
                }
                ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal Contact -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="contactModalLabel">Contactez moi !</h4>
      </div>
      <div class="modal-body">
        <form role="form" id="contactForm">
            <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="name" class="h4">Nom, Prénom</label>
                            <input type="text" data-error="Recommencez!" class="form-control" id="name" placeholder="Nom, Prénom" required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="email" class="h4">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Votre email" required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="tel" class="h4">Téléphone</label>
                            <input type="tel" class="form-control" id="tel" placeholder="Votre téléphone">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="h4 ">Message</label>
                        <textarea id="message" class="form-control" rows="5" placeholder="Votre message" required></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" data-dismiss="modal">Fermer</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <button type="submit" id="form-submit" class="btn btn-success pull-right ">Envoyer</button>
<div id="msgSubmit" class="h3 text-center hidden">Message Envoyé!</div>
</form>
      </div>
    </div>
  </div>
</div>

<?php
if (!empty($_GET['action']) && $_GET['action'] == 'commentaire') :
?>
        <div class="row">
            <div class="comment_form col-xs-10 col-xs-offset-1 col-md-4  col-md-offset-4 ">
                <br><form action="" method="post">
                    <fieldset class="form-group">
                        <legend>Laissez un commentaire</legend>
                        <p>
                            <label for="commentaire"></label>
                            <textarea name="commentaire" id="commentaire" class="form-control" cols="30" rows="10" placeholder="Commentaire"></textarea>
                        </p>
                        <button type="submit" class="btn-in-out">
							<span>Envoyer</span>
						</button>
                    </fieldset>
                </form>
            </div>
            <div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 text-center">
                <?php echo $contenu; ?>
            </div>
        </div>
<?php
endif;

if (!empty($_GET['action']) && $_GET['action'] == 'avis') :
?>
        <div class="row">
            <div class="comment_form col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 ">
                <form action="" method="post" id="form-avis">
                    <fieldset class="form-group">
                        <legend>Laissez un avis</legend>
                <select class="form-control" name="note" id="note" aria-required="true">
                							<option value="5">5</option>
                							<option value="4">4</option>
                							<option value="3">3</option>
                							<option value="2">2</option>
                							<option value="1">1</option>
                						</select><br><br>

                                   <input type="hidden" value="'.$id_annonce.'" id="id_annonce">
                                   <input type="hidden" value="'.$id_membre.'" id="id_membre">
                            <div style="display:none" id="button-area">

                               <textarea name="avis" id="avis" class="form-control"  cols="15" rows="2" placeholder="Laissez un avis"></textarea><br>
                               <button type="submit" class="btn col-md-4 col-md-offset-8">Envoyer</button>
                            </div>
                </form><br>

            </div>
            <div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 text-center">
                <?php echo $contenu; ?>
            </div>
        </div>
<?php
endif;
?>

<script>
    $(function(){

        $('#note').on('change',function(){

            $('#button-area').css('display','block');
            $('#form-avis').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                url:'avis-ajax.php',
                method:'post',
                data:{
                    note:$('#note').val(),
                    id_annonce:$('#id_annonce').val(),
                    avis:$('#avis').val(),
                    id_membre:$('#id_membre').val()
                     },
                success:function(data){

                    $('#button-area').html(data)
                }
                        })
                        })
                        })

        $('#form-commnt').on('submit',function(){

            e.preventDefault();
            $('#btn-com').on('click',function(){


                           $('#form-commnt')[0].reset();
        })

        })
    })
</script>
<script>
  $(function(){
    $("#myModal").modal("show");
  });
</script>


<?php
require_once ('inc/bas.inc.php');

 ?>
