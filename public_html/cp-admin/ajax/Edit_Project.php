<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../../include/dataconnect.php");
// Security one

$Project=$_GET["Project"];
$Num=$_GET['Num'];
	$sql="DELETE FROM project_image where F_Project='$Project' and Num='$Num'";
		  $result=mysql_query($sql,$link);



 echo '   <table style="margin-left:22px; border:hidden; " width="90%"  border="0">
  <tr style="text-align:center;">';
  
  $i=1;
 	  $q35="select * from project_image where F_Project='$Project'";
                      $r35=mysql_query($q35,$link);
           while($row35=@mysql_fetch_array($r35))
		                  {
							  $j=$row35['Num'];	

							  if($i<4)
{
    echo '<td> '; 
echo" <img src='img/Delete-icon.png'  width='20' height='20' style='margin-bottom:62px; cursor:pointer;'  onclick='Delete(".$Project.",".$j.")'/> ";
   echo' <img width="100" height="100"
     style="
 /* top-left corner */
border-top-left-radius: 10px;
-moz-border-radius-topleft: 10px;
-webkit-border-top-left-radius: 10px;

/* bottom-right corner */
border-bottom-right-radius: 10px;
-moz-border-radius-bottomright: 10px;
-webkit-border-bottom-right-radius: 10px;


/* bottom-left corner */
border-bottom-left-radius: 10px;
-moz-border-radius-bottomleft: 10px;
-webkit-border-bottom-left-radius: 10px;
" 
 src="../image/Project/'.$row35['Link'].'"  />
 </td>';
 $i++;
}

else
{
	    echo '<td> '; 
echo" <img src='img/Delete-icon.png'  width='20' height='20' style='margin-bottom:62px; cursor:pointer;'  onclick='Delete(".$Project.",".$j.")'/> ";
   echo' <img width="100" height="100"
     style="
 /* top-left corner */
border-top-left-radius: 10px;
-moz-border-radius-topleft: 10px;
-webkit-border-top-left-radius: 10px;

/* bottom-right corner */
border-bottom-right-radius: 10px;
-moz-border-radius-bottomright: 10px;
-webkit-border-bottom-right-radius: 10px;


/* bottom-left corner */
border-bottom-left-radius: 10px;
-moz-border-radius-bottomleft: 10px;
-webkit-border-bottom-left-radius: 10px;
" 
 src="../image/Project/'.$row35['Link'].'"  />
 </td>';
	
	
	
	echo "</tr>  <tr style='text-align:center;'>
";
							$i=1;
}
						  }
						  ?>
 
   
  </tr>
</table>




