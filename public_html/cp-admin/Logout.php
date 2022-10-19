<?php session_start();
include("include/dataconnect.php");
   
     unset($_SESSION['User']);
	// unset($_SESSION['total']);

	
	
	/* $query11="select * from orderr where F_Cart='$idCart'";
$result11=mysql_query($query11,$link);	
$Row=@mysql_fetch_array($result11);



$rownum=@mysql_num_rows($result11);

if(($rownum<1)|| (!isset($_SESSION['Agree'])) )
{  
	$result66=mysql_query("DELETE FROM orderr 
where F_Cart=$idCart ",$link);
	$result1=mysql_query("DELETE FROM cart 
where idCart=$idCart ",$link);
	
}

	*/


if (isset($_SESSION['Agree']))
     unset($_SESSION['Agree']);
	
	
	session_destroy();
 
 echo "<META HTTP-EQUIV='Refresh' Content='0;URL=index.php'>";

?>