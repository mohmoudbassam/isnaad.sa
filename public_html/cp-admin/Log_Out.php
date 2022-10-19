<?PHP
session_start();
include("../include/dataconnect.php");
$ID_Manager=$_SESSION['USERID'];
$result=mysql_query("UPDATE admin SET Log_in=0 where idAdmin= '$ID_Manager'",$link);
unset($_SESSION['USERID']);
unset($_SESSION['Manegar']);

session_destroy();
header("location:login.php");

?>