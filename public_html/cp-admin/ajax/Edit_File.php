<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../../include/dataconnect.php");
// Security one

$Product=$_GET["Product"];

	$sql="UPDATE product  SET File='' Where idProduct='$Product'";
    $result=mysql_query($sql,$link);



 echo '  
  <table style="margin-left:22px; border:hidden; " width="90%"  border="0">
  <tr style="text-align:center;">
 ';
 
  $q35="select * from product where idProduct='$Product'";
  $r35=mysql_query($q35,$link);
  $row=mysql_fetch_array($r35);
 
if($row['File'] !='')
{
    echo '<td>'; 
echo" <img src='img/Delete-icon.png'  width='20' height='20' style='margin-bottom:62px;  cursor:pointer;'  onclick='Deletef(".$product.")'/> ";
   echo' <a href="../Files/'.$row['File'].'"><img width="60" height="60" src="../Files/download.png"  /></a>';
    $path='../Files/'.$row['File'].'';
 $ext = pathinfo($path,PATHINFO_EXTENSION);
 echo $ext;
 echo'
 </td>';

}
else
{
	echo"<center><h4> لا يوجد  </h4></center>";
	
}



	
	
	echo "</tr>  <tr style='text-align:center;'>
";
							

						  
						echo'
 
   
  </tr>
</table>';


  ?>

