<?php
    require_once('inc/init.inc.php');

                $cat=executeRequete("SELECT * FROM categorie ORDER BY titre");
                $result_cat =$cat->fetchAll((PDO::FETCH_ASSOC));

 //---------------------- Affichage des filtres -------------------------------
    $contenu_gauche='<br />';
    $contenu_gauche .= '<div class="form-group">';
        $contenu_gauche .= '<label for="list-cat">Catégorie</label>';
        $contenu_gauche .= '<form method="GET">';
            $contenu_gauche .= '<select name="categorie" id="list-cat" class="form-control">';
            $contenu_gauche .= '<option>Toutes les catégories</option>';
                foreach($result_cat as $valTitre){
/*                var_dump($result_cat);*/
                $contenu_gauche .= '<option name="categorie" value ="'.$valTitre['id'] . '">'. $valTitre['titre'] . '</option>';
}
        $contenu_gauche .= '</select>';

        $contenu_gauche .= '<label for="list-reg">Région</label>';
        $contenu_gauche .= '<select id="list-reg" class="form-control">';
            $contenu_gauche .= '<option>Toutes les régions</option>';
            $contenu_gauche .= '<option>Region 1</option>';
            $contenu_gauche .= '<option>Region 2</option>';
            $contenu_gauche .= '<option>Region 3</option>';
        $contenu_gauche .= '</select>';

                $member=$pdo->query("SELECT * FROM membre ORDER BY prenom");
                $result_member =$member->fetchAll((PDO::FETCH_ASSOC));
        $contenu_gauche .= '<label for="list-member">Membre</label>';
        $contenu_gauche .= '<form method="get">';
        $contenu_gauche .= '<select name="membre" id="list-member" class="form-control">';
            $contenu_gauche .= '<option>Tous les membres</option>';
                foreach($result_member as $valName){
/*                var_dump($result);*/
                $contenu_gauche .= '<option value="'. $valName['id'] .'">' . $valName['prenom'] . ' ' . $valName['nom'] . '</option>';
}
        $contenu_gauche .= '</select><br />';
        $contenu_gauche .= '<input name="submit" type="submit" value="submit" class="form-control">';
        $contenu_gauche .= '</form>';
        $contenu_gauche .= '</div>';

/*    $contenu_gauche .= '</div>';*/
    $contenu_droite='<br />';
    $contenu_droite .= '<div class = "form-group">';
        $contenu_droite .= '<select class="form-control">';
            $contenu_droite .= '<option>Trier croissant par prix (du - cher au + cher)</option>';
            $contenu_droite .= '<option>Trier décroissant par prix (du + cher au - cher)</option>';
            $contenu_droite .= '<option>Trier croissant par date (de la + récente à la + ancienne)</option>';
            $contenu_droite .= '<option>Trier décroissant par date (de la + ancienne à la + récente)</option>';
        $contenu_droite .= '</select>';

if(isset($_GET['submit']) && $_GET['categorie'] != 'Toutes les catégories' && $_GET['membre_id'] != 'Tous les membres'){//si on a cliqué sur une catégorie différent de toutes les catégoriesif

            $donnees = executeRequete("SELECT * FROM annonce WHERE categorie_id =". $_GET['categorie']);
/*    var_dump($donnees);*/

}elseif (isset($_GET['submit']) && $_GET['categorie'] != 'Toutes les catégories'){
            $donnees = executeRequete("SELECT * FROM annonce WHERE categorie_id =". $_GET['categorie']);

}elseif (isset($_GET['submit']) && $_GET['membre_id'] != 'Tous les membres'){
            $donnees = executeRequete("SELECT * FROM annonce WHERE membre_id = ". $_GET['membre_id']);
}else{
    $donnees = executeRequete("SELECT * FROM annonce");
}

while ($annonce = $donnees->fetch(PDO::FETCH_ASSOC)){
/*        var_dump($annonce);*/
        $contenu_bas .= '<div class="col-md-3">';
            $contenu_bas .= '<div class="thumbnail">';
                $contenu_bas .= '<h4>' . $annonce['titre'] . '</h4>';
                //une photo cliquable
                $contenu_bas .= '<a href="fiche_annonce.php?id='. $annonce['id'] .'"><img src="'. $annonce['photo'] .'"style="width:280px; height:250px;" alt="'. $annonce['titre'] .'"></a>';

            //les infos du produit:
            $contenu_bas .= '<div class="caption">';
                $contenu_bas .= '<h4 class="pull-right">' . $annonce['prix'] . ' €</h4>';
                $contenu_bas .= '<p>' . $annonce['description_longue'] . '</p>';

            $contenu_bas .= '</div>';

            $contenu_bas .= '</div>';
        $contenu_bas .= '</div>';
    }
require_once('inc/haut.inc.php');
?>
    <div class="row">
        <div class="col-md-3">
            <?php echo $contenu_gauche; ?>
        </div>
            <div class="row">
                <div class="col-md-7 col-md-offset-1">
                    <?php echo $contenu_droite; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <?php echo $contenu_bas; ?>
                </div>

        </div>
    </div>

<?php
require_once('inc/bas.inc.php');
 ?>


!preg_match('#^[0-9]{1,}(\.|)[0-9]{0,2}$#'
