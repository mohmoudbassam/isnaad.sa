<?php session_start();?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../include/dataconnect.php");
// Security one

$Word=$_GET["Word"];
$Catg=$_GET["Catg"];





 
	    echo'
                                            <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%">#</th>
                                                <th style="width: 20%">إسم المشروع</th>
                                                <th>العميل</th>
                                                <th> صورة المشروع</th>
												<th>الظهور</th>
                                               
                                                <th style="width: 20%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                        
                                  
										 $sql_P="SELECT customer.*,project.*
												 FROM customer inner JOIN project 
												 ON customer.idCustomer = project.F_Customer
												 and project.F_Category='$Catg'
												 and (project.Name LIKE '%$Word%' or customer.Name LIKE '%$Word%')
												 GROUP BY project.idProject
												 order by project.idProject DESC";
												 
                                         $result_P=mysql_query($sql_P,$link);
								         while($row_P=@mysql_fetch_array($result_P))
										 {
                                                $Project=$row_P['idProject'];
											    $Customer=$row_P['F_Customer'];
												
		                                        $sql2="select * from project_image  Where F_Project='$Project'";
		                                        $result2=mysql_query($sql2,$link);
		                                         $row2=mysql_fetch_array($result2);
												 
												 
												 $sql_User="select * from customer where idCustomer=$Customer";
                                                 $result_User=mysql_query($sql_User,$link);
             								     $row_User=mysql_fetch_array($result_User);
												
												
												
										
										 echo'
                                        
                                            <tr>
                                                <td>#</td>
                                                <td>
                                                    <a href="Project.php?id='.$row_P['idProject'].'">'.$row_P['Name'].'</a>
                                                   
                                                </td>
                                                <td>';
												
												
                                                    echo'<a href="Customer.php?id='.$row_User['idCustomer'].'">'.$row_User['Name'].'</a>';
													
                                                   echo'
                                                </td>
                                              <td>
                                                <img class="img-circle " style="width:70px; height:70px;" src="../image/Project/'.$row2['Link'].'" alt="">';
                                            
                                                echo'</td>';
												
												
                                                echo'<td>';
												if ($row_P['Sho']==2)
                                                    echo'<button type="button" class="btn btn-success btn-xs">ظاهر</button>';
										        else if($row_P['Sho']==1)
                                                    echo'<button type="button" class="btn btn-warning btn-xs">مخفي</button>';
                                                echo'</td>';
												
												
											echo'
												
                                                <td>
                                                    <a href="Project.php?id='.$row_P['idProject'].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> تعديل </a>
                                      <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row_P['idProject'].','.$Catg.');"><i class="fa fa-trash-o"></i> حذف </a>                                                </td>
                                            </tr>';
										 }
										echo'
                                           
                                        </tbody>
                                    </table>';
                                           

?>

