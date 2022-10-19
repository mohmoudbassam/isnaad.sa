<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../../include/dataconnect.php");
// Security one

$id=$_GET["id"];
	$sql="DELETE FROM slider where idSlider='$id'";
		  $result=mysql_query($sql,$link);



                       
                   echo'  <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%">#</th>
                                                <th style="width: 20%">إسم الصورة</th>
                                                <th>Image Name</th>
                                                <th>الصورة  </th>
                                                <th>الحالة</th>
                                                <th style="width: 20%">#خيارات </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    ';
										
		   $sql="select * from slider ";
		   $result=mysql_query($sql,$link);
	


                    while($row=@mysql_fetch_array($result))
                               {
	
					                   echo'
                                            <tr>
                                                <td>#</td>
                                                <td>
                                                    <a  href="Slider.php?id='.$row['idSlider'].'">'.$row['Name'].'</a>
                                                   
                                                </td>
                                                <td>
                                                    <a href="Slider.php?id='.$row['idSlider'].'">'.$row['Name_E'].'</a>
                                                   
                                                </td>
                                               <td>
                                                <img class="img-circle " style="width:auto; height:50px;" src="../image/Slider/'.$row['Link'].'" alt="">
                                             </td>
                                                <td>';
												if ($row['Sho']==2)
                                                    echo'<button type="button" class="btn btn-success btn-xs">ظاهر</button>';
										        else if($row['Sho']==1)
                                                    echo'<button type="button" class="btn btn-warning btn-xs">مخفي</button>';
                                                echo'</td>
                                                <td>
                                                    <a href="Slider.php?id='.$row['idSlider'].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> تعديل </a>
                                                    <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row['idSlider'].');"><i class="fa fa-trash-o"></i> حذف </a>
                                                </td>
                                            </tr>';
                                           }
											echo'
                                          
                                        </tbody>
                                    </table>';
									  
                                            ?> 
                    
                            
                   




