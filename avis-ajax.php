<?php
require_once('inc/init.inc.php');

$note=$_POST['note'];
$id_annonce=$_POST['annonce_id'];
$id_membre2=$_POST['membre_id'];
$avis=$_POST['avis'];


if($_POST){
    $req2 =executeRequete("INSERT INTO note (note,avis,membre1_id,membre2_id)value(:note,:avis,:membre1_id,:membre2_id)",array(
        ':note'=>intval($note),
        ':avis'=>$avis,
        ':id_membre1'=>$_SESSION['membre']['id'],
        ':id_membre2'=>$id_membre2

    ));

    echo '<h2 class="text-center">Merci pour votre avis<h2>';



}
