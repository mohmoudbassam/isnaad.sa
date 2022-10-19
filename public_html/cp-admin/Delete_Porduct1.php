<?php session_start();?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../include/dataconnect.php");
// Security one

$id=$_GET["id"];
$Member=$_GET["user"];


$result1=mysql_query("DELETE FROM product_image
where F_Product=$id",$link);

$result1=mysql_query("DELETE FROM comment
where F_Product=$id",$link);


$result1=mysql_query("DELETE FROM likee
where F_Product=$id",$link);

$result1=mysql_query("DELETE FROM product
where idProduct=$id",$link);


 
	    echo'
                                            <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%">#</th>
                                                <th style="width: 20%">إسم المنتج</th>
                                                <th>صلاحية الإعلان/ أيام</th>
                                                <th>صورة المنتج</th>
                                                <th>الظهور</th>
                                                <th>الحالة</th>
                                                <th style="width: 20%">#خيارات </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            ';								
								         $sql_P="select * from product where F_User='$Member' ";
                                         $result_P=mysql_query($sql_P,$link);
								         while($row_P=@mysql_fetch_array($result_P))
										 {
											 
											    $Product=$row_P['idProduct'];
											
		                                        $sql2="select * from product_image  Where F_Product='$Product'";
		                                        $result2=mysql_query($sql2,$link);
		                                         $row2=mysql_fetch_array($result2);

                                         echo'   <tr>
                                                <td>#</td>
                                                <td>
                                                    <a href="Product.php?id='.$row_P['idProduct'].'">'.$row_P['Name'].'</a>
                                                   
                                                </td>
                                                <td>
                                                   
                                      ';
									      $S_Date = strtotime($row_P['S_Date']); 
                                          $E_Date = strtotime($row_P['E_Date']); 
                                          $datediff = $E_Date- $S_Date ;
                                          $x= floor($datediff/(60*60*24));
										  
										  if ($x==0)
										  {
										  if ($row_P['Type']==0)
										  echo '<div style="color:green;">مفتوح</div>';
										  else
										  echo'<div style="color:red;">إنتهت الفترة</div>';
										  }
										  else
										  echo $x;
										  
									  
									  
                                               
                                        echo'        </td>
                                             
                                              <td>
                                                <img class="img-circle " style="width:70px; height:70px;" src="../image/Product/'.$row2['Link'].'" alt="">';
                                            
                                                echo'</td>
                                                <td>';
												if ($row_P['Sho']==2)
                                                    echo'<button type="button" class="btn btn-success btn-xs">ظاهر</button>';
										        else if($row_P['Sho']==1)
                                                    echo'<button type="button" class="btn btn-warning btn-xs">مخفي</button>';
                                                echo'
												</td>';
                                                 
												 
												   echo'<td>';
												if ($row_P['Sold']==2)
                                                    echo'<button type="button" class="btn btn-warning btn-xs">مباع</button>';
										        else if($row_P['Sold']==1)
                                                    echo'<button type="button" class="btn btn-success btn-xs">متاح</button>';
                                                echo'</td>';

                                            echo'    <td>
                                                    <a href="Product.php?id='.$row_P['idProduct'].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> تعديل </a>
                                                    <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row_P['idProduct'].','.$Member.');"><i class="fa fa-trash-o"></i> حذف </a>           
                                                </td>
                                            </tr>';
										 }
                                     
                                          
                                     echo'   </tbody>
                                    </table>';
                                           

?>

