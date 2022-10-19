<?php session_start();?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../include/dataconnect.php");
// Security one

$idCustomer=$_GET["id"];

$result1=mysql_query("DELETE FROM partner
where idPartner=$idCustomer",$link);


 
	    echo'
                                         <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%">#</th>
                                                <th style="width: 20%">إسم الشريك</th>
                                                <th>Partner Name</th>
                                                <th>صورة الشريك</th>
                                                <th>الحالة</th>
                                                <th style="width: 20%">#خيارات </th>
                                            </tr>
                                        </thead>
                                        <tbody>';
		                             $sql="select * from partner ";
		                             $result=mysql_query($sql,$link);
                                     while($row=@mysql_fetch_array($result))
                                      {
	
					                   echo'
                                            <tr>
                                                <td>#</td>
                                                <td>
                                                    <a href="Edit_Partner.php?id='.$row['idPartner'].'">'.$row['Name'].'</a>
                                                   
                                                </td>
                                                <td>
                                                  <a href="Edit_Partner.php?id='.$row['idPartner'].'">'.$row['Name_E'].'</a>
                                                   
                                                </td>
                                             
                                             <td>
                                                <img class="img-circle " style="width:70px; height:70px;" src="../image/Partner/'.$row['Image'].'" alt="">
                                             </td>
                                             
                                                <td>';
												if ($row['Sho']==2)
                                                    echo'<button type="button" class="btn btn-success btn-xs">ظاهر</button>';
										        else if($row['Sho']==1)
                                                    echo'<button type="button" class="btn btn-warning btn-xs">مخفي</button>';
                                                echo'</td>
                                                <td>
                                                    <a href="Edit_Partner.php?id='.$row['idPartner'].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> تعديل </a>
                                                    <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row['idPartner'].');"><i class="fa fa-trash-o"></i> حذف </a>
                                                </td>
                                            </tr>';
							   }
							 echo'
                                           
                                           
                                           
                                        </tbody>
                                    </table>';
                                           

?>

