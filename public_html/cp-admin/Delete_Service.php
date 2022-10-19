<?php session_start();?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../include/dataconnect.php");
// Security one

$idService=$_GET["id"];

 
  $sql="select * from service where idService='$idService' ";
  $result=mysql_query($sql,$link);
  $row=mysql_fetch_array($result);
  unlink('../image/Services/'.$row['Image'].'');


$result1=mysql_query("DELETE FROM service
where idService=$idService",$link);


 
	    echo'
                                               <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%">#</th>
                                                <th style="width: 20%">إسم الخدمة</th>
                                                <th>Service Name</th>
                                                <th>صورة الخدمة </th>
                                                <th>الحالة</th>
                                                <th style="width: 20%">#خيارات </th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                    
                                      
										
		   $sql="select * from service ";
		   $result=mysql_query($sql,$link);
	


                    while($row=@mysql_fetch_array($result))
                               {
	
					                   echo'
                                            <tr>
                                                <td>#</td>
                                                <td>
                                                    <a  href="Service.php?id='.$row['idService'].'">'.$row['Name'].'</a>
                                                   
                                                </td>
                                                <td>
                                                    <a href="Service.php?id='.$row['idService'].'">'.$row['Name_E'].'</a>
                                                   
                                                </td>
                                               <td>
                                                <img class="img-circle " style="width:70px; height:70px;" src="../image/Services/'.$row['Image'].'" alt="">
                                             </td>
                                                <td>';
												if ($row['Sho']==2)
                                                    echo'<button type="button" class="btn btn-success btn-xs">ظاهر</button>';
										        else if($row['Sho']==1)
                                                    echo'<button type="button" class="btn btn-warning btn-xs">مخفي</button>';
                                                echo'</td>
                                                <td>
                                                    <a href="Service.php?id='.$row['idService'].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> تعديل </a>
                                                    <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row['idService'].');"><i class="fa fa-trash-o"></i> حذف </a>
                                                </td>
                                            </tr>';
                                           }
										
                                            
                                       
                                          
                                          
                                          
                                      echo'  </tbody>
                                    </table>';
                                           

?>

