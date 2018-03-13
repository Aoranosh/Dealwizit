<?php



//Database connection.

$con = MySQLi_connect(

   "serflex.o2switch.net", //Server host name.

   "aoranosh", //Database username.

   "_+XJPdXAA0Hp", //Database password.

   "aoranosh_dealwizit" //Database name or anything you would like to call it.

);



//Check connection

if (MySQLi_connect_errno()) {

   echo "Failed to connect to MySQL: " . MySQLi_connect_error();

}

?>
