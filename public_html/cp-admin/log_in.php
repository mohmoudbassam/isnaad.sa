<?php session_start();
include("../include/dataconnect.php");

// Security one
$password = stripslashes($_GET["Pass"]);
$username = mysql_real_escape_string($_GET["User"]);
//

$Password=md5($_GET["Pass"]);
$User=$_GET["User"];


$password = stripslashes($Password);
$password = mysql_real_escape_string($password);


$User = stripslashes($User);
$User = mysql_real_escape_string($User);


$query="select * from admin where Password='$Password' and Username='$User'";
$result=mysql_query($query,$link);	
$row=mysql_fetch_array($result);
$rownum=@mysql_num_rows($result);

if($rownum==0)
{  
 
echo "فشل التسجيل , حاول مرة أخرى";
}
else
{
    
	$_SESSION['Name']=$row['Username'];
    $_SESSION['USERID']=$row['idAdmin'];
	$i=	$_SESSION['USERID'];
	
	
	//$query22="select * from admin where idAdmin='$i'";
//$result22=mysql_query($query22,$link);	
//$row22=mysql_fetch_array($result22);
//if( $row22['Type']==1)
//{
	//$_SESSION['Manegar']=1;
	
//}

	$result=mysql_query("UPDATE admin SET Log_in=1 where Password='$Password' and Username='$User'",$link);

	echo "True";
}

?>