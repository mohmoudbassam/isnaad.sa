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
                                                <th style="width: 20%">إسم المنتج</th>
                                                <th>الفنان</th>
                                                <th> صورة المنتج</th>
												<th>الظهور</th>
                                                <th>الحالة</th>
                                                <th>السعر</th>
                                                <th style="width: 20%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                        
                                  
										 $sql_P="SELECT user.*,product.*
												 FROM user inner JOIN product 
												 ON user.idUser = product.F_User
												 and product.F_Category='$Catg'
												 and (product.Name LIKE '%$Word%' or user.Name LIKE '%$Word%')
												 GROUP BY product.idProduct
												 order by product.idProduct DESC";
												 
                                         $result_P=mysql_query($sql_P,$link);
								         while($row_P=@mysql_fetch_array($result_P))
										 {
                                                $Product=$row_P['idProduct'];
											    $User=$row_P['F_User'];
												
		                                        $sql2="select * from product_image  Where F_Product='$Product'";
		                                        $result2=mysql_query($sql2,$link);
		                                         $row2=mysql_fetch_array($result2);
												 
												 
												 $sql_User="select * from user where idUser=$User";
                                                 $result_User=mysql_query($sql_User,$link);
             								     $row_User=mysql_fetch_array($result_User);
												
												
												
										 echo'
                                        
                                            <tr>
                                                <td>#</td>
                                                <td>
                                                    <a href="Product.php?id='.$row_P['idProduct'].'">'.$row_P['Name'].'</a>
                                                   
                                                </td>
                                                <td>';
												
												
                                                    echo'<a href="Member.php?id='.$row_User['idUser'].'">'.$row_User['Name'].'</a>';
													
                                                   echo'
                                                </td>
                                              <td>
                                                <img class="img-circle " style="width:70px; height:70px;" src="../image/Product/'.$row2['Link'].'" alt="">';
                                            
                                                echo'</td>';
												
												
                                                echo'<td>';
												if ($row_P['Sho']==2)
                                                    echo'<button type="button" class="btn btn-success btn-xs">ظاهر</button>';
										        else if($row_P['Sho']==1)
                                                    echo'<button type="button" class="btn btn-warning btn-xs">مخفي</button>';
                                                echo'</td>';
												
												
												
												  echo'<td>';
												if ($row_P['Sold']==2)
                                                    echo'<button type="button" class="btn btn-warning btn-xs">مباع</button>';
										        else if($row_P['Sold']==1)
                                                    echo'<button type="button" class="btn btn-success btn-xs">متاح</button>';
                                                echo'</td>';
												
												
												echo'
												
												 <td>
                                                   '.$row_P['Price'].'
                                                   
                                                </td>
												
                                                <td>
                                                    <a href="Product.php?id='.$row_P['idProduct'].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> تعديل </a>
                                      <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row_P['idProduct'].','.$Catg.');"><i class="fa fa-trash-o"></i> حذف </a>                                                </td>
                                            </tr>';
										 }
										 echo'
                                     
                                           
                                        </tbody>
                                    </table>';
                                           

?>

