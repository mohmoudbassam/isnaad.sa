<?php session_start();?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../include/dataconnect.php");
// Security one

$idService=$_GET["idService"];

$result1=mysql_query("DELETE FROM service
where idService=$idService",$link);


   $sql2="select * from service ";
  $result2=mysql_query($sql2,$link);
	 


echo '



   <table  class="data display datatable" id="example">
					<thead > 
						<tr>
                        	<th>&nbsp; &nbsp;</th>
							<th> حذف</th>
							<th>تعديل</th>
						<th> Service Name</th>
							<th>إسم الخدمة</th>
						</tr>
					</thead>
					<tbody>
                   ';
                    while($row2=@mysql_fetch_array($result2))
{
	
					echo'	<tr class="odd gradeX">
							<td></td>
<td><a  style="margin-top:5px;"  class="btn-mini btn-black btn-minus"  onclick="Delete('.$row2['idService'].');"><span></span>Remove</a>
</td>
<td><a href="Edit_Service.php?id='.$row2['idService'].'"  style="margin-top:5px;"  class="btn-mini btn-black btn-refresh"><span></span>refresh</a>
</td>	
<td class="center" style="font-size:13px; font-weight:700;  vertical-align:middle;"><a href="Edit_Service.php?id='.$row2['idService'].'">'.$row2['Name_E'].'</a></td>						
<td class="center" style="font-size:13px; font-weight:700;  vertical-align:middle;"><a href="Edit_Service.php?id='.$row2['idService'].'">'.$row2['Name'].'</a></td>
						</tr>';
}

echo'					
						
					</tbody>
				</table>

';
	

?>

