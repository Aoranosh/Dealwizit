<?php

//Including Database configuration file.
include "db.php";
//Getting value of "search" variable from "script.js".
if (isset($_POST['search'])) {

  if ( $_POST['action'] == 'cherche_id')
  {
    $id_annonce=$_POST['search'];
    $suite_requete=' annonce.id = '.$id_annonce;

  }
  else {

    $titre = $_POST['search'];
    $suite_requete=" titre LIKE '%$titre%' LIMIT 5";
    # code...
  }


//Search box value assigning to $Name variable.

//Search query.
   $Query = "SELECT titre,id FROM annonce WHERE ".$suite_requete;
//Query execution
   $ExecQuery = MySQLi_query($con, $Query);



   if ( $_POST['action'] == 'cherche_id')
   {

     $retour='';

     if ($Result = MySQLi_fetch_array($ExecQuery)) {
     $retour .= $Result['titre'];
    }

    echo $retour;

   }
   else {
     # code...


//Creating unordered list to display result.
   echo '<ul style="list-style-type:none;">';

   //Fetching result from database.
   while ($Result = MySQLi_fetch_array($ExecQuery)) {
       ?>
   <!-- Creating unordered list items.
        Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->
   <li onclick='fill1("<?php echo $Result['titre']; ?>");fill2("<?php echo $Result['id']; ?>")'>
   <a>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
       <?php echo $Result['titre']; ?>
   </li></a>
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
   <?php
}}
?>
</ul>
<?php } ?>
