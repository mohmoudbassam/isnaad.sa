<?php session_start();?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../include/dataconnect.php");
// Security one

$idSection=$_GET["id"];

$result1=mysql_query("DELETE FROM projsection
where idProjsection=$idSection",$link);


 
	    echo'
                                              <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%">#</th>
                                                <th style="width: 20%">إسم القسم</th>
                                                <th>Section Name</th>
                                                <th>التصنيفات الداخلية</th>
                                                <th>الحالة</th>
                                                <th style="width: 20%">#خيارات </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    ';
		                           $sql="select * from projsection ";
		                           $result=mysql_query($sql,$link);
                                   while($row=@mysql_fetch_array($result))
                                   {
                                        $Section=$row['idProjsection'];
                                          echo'  <tr>
                                                <td>#</td>
                                                <td>
                                                    <a href="Catg.php?id='.$row['idProjsection'].'">'.$row['Name'].'</a>
                                                   
                                                </td>
                                                <td>
                                                    <a href="Catg.php?id='.$row['idProjsection'].'">'.$row['Name_E'].'</a>
                                                   
                                                </td>
                                                 <td>';
                                                    $sql1="select Count(*) as Cate from projcateg  Where F_Section=$Section";
		                                            $result1=mysql_query($sql1,$link);
		                                            $row1=@mysql_fetch_array($result1);
												   echo $row1['Cate'];
                                                   
                                                 echo'</td>
                                            
                                                <td>';
												if ($row['Sho']==2)
                                                    echo'<button type="button" class="btn btn-success btn-xs">ظاهر</button>';
										        else if($row['Sho']==1)
                                                    echo'<button type="button" class="btn btn-warning btn-xs">مخفي</button>';
                                                echo'</td>
                                              
                                                <td>
                                     <a href="Edit_PSection.php?id='.$row['idProjsection'].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> تعديل </a>
                                     <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row['idProjsection'].');"><i class="fa fa-trash-o"></i> حذف </a>
                                     <a href="PCatg.php?id='.$row['idProjsection'].'" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> التصنيفات </a>
                                                </td>
                                            </tr>';
							   }
							  echo'
                                            
                                           
                                           
                                        </tbody>
                                    </table>';
                                           

?>

