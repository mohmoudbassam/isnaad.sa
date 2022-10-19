<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../../include/dataconnect.php");


$Product=$_GET["Product"];


	$sql="UPDATE download  SET  Link='' Where idDownload='$Product'";
$result=mysql_query($sql,$link);




