<?php session_start();?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../include/dataconnect.php");
// Security one

$idCateg=$_GET["id"];
$Section=$_GET["Section"];

$result1=mysql_query("DELETE FROM category
where idCategory=$idCateg",$link);


 
	    echo'
                                                <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%">#</th>
                                                <th style="width: 20%">إسم التصنيف</th>
                                                <th> Category Name</th>
                                                <th> المنتجات الداخلية</th>
                                                <th>الحالة</th>
                                                <th style="width: 20%">#خيارات </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                       ';
										 $sql_Cat="select * from category where F_Section='$Section' ";
                                         $result_Cat=mysql_query($sql_Cat,$link);
								         while($row_Cat=@mysql_fetch_array($result_Cat))
										 {
                                                $category=$row_Cat['idCategory'];
										 echo'
                                            <tr>
                                                <td>#</td>
                                                <td>
                                                    <a href="Products.php?id='.$row_Cat['idCategory'].'">'.$row_Cat['Name'].'</a>
                                                   
                                                </td>
                                                <td>
                                                    <a href="Products.php?id='.$row_Cat['idCategory'].'">'.$row_Cat['Name_E'].'</a>
                                                   
                                                </td>
                                              <td>';
                                                    $sql1="select Count(*) as Product from product  Where F_Category=$category";
		                                            $result1=mysql_query($sql1,$link);
		                                            $row1=@mysql_fetch_array($result1);
												   echo $row1['Product'];
                                                   
                                                 echo'</td>
                                                <td>';
												if ($row_Cat['Sho']==2)
                                                    echo'<button type="button" class="btn btn-success btn-xs">ظاهر</button>';
										        else if($row_Cat['Sho']==1)
                                                    echo'<button type="button" class="btn btn-warning btn-xs">مخفي</button>';
                                                echo'
                                                <td>
                                 <a href="Edit_Catg.php?id='.$row_Cat['idCategory'].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> تعديل </a>
                                 <a href="#" class="btn btn-danger btn-xs" onclick="Delete('.$row_Cat['idCategory'].','.$Section.');"><i class="fa fa-trash-o"></i> حذف </a>
                                 <a href="Products.php?id='.$row_Cat['idCategory'].'" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> المنتجات </a>

                                                </td>
                                            </tr>';
										 }
											echo'
                                          
                                        </tbody>
                                    </table>';
                                           

?>

