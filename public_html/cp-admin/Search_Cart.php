<?php session_start();?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../include/dataconnect.php");
// Security one

$Word=$_GET["Word"];



 
	    echo'
		
		
		
		  <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                        <thead>
                                            <tr class="headings">
                                                <th>
                                                    <input type="checkbox" id="check-all" class="flat">
                                                </th>
                                                <th class="column-title">رقم الطلبية </th>
                                                <th class="column-title">تاريخ الطلبية </th>
                                                <th class="column-title">رقم المشتري </th>
                                                <th class="column-title">إسم المشتري </th>
                                                <th class="column-title">حالة الطلبية </th>
                                                <th class="column-title">التكلفة </th>
                                                <th class="column-title no-link last"><span class="nobr">الخيارات</span>
                                                </th>
                                                <th class="bulk-actions" colspan="7">
                                                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                </tr>
                            </thead>

                            <tbody>
                            
                               ';
								$sql_P="select * from cart 
								inner join user
								on cart.F_User=user.idUser 
								Where (cart.idCart ='$Word'  or user.name like '%$Word%' or user.Username like '%$Word%' )
								order by idCart DESC";
                                $result_P=mysql_query($sql_P,$link);
								while($row_P=@mysql_fetch_array($result_P))
				                  {
                            
                         
                            if ($row_P['Watch']==1)
							{
                            echo'    <tr class="even pointer" style="background:#fff5cd;">
                                    <td class="a-center "><input type="checkbox" class="flat" name="table_records" ></td>
                                    <td class=" ">'.$row_P['idCart'].'</td>
                                    <td class=" ">'.$row_P['Date'].' </td>
                                    <td class=" ">'.$row_P['Mobile'].' </td>
                                    <td class=" "><a href="Profile.php?id='.$row_P['idUser'].'">'.$row_P['Name'].'</a></td>';
									if ($row_P['Done']==2)
                                    echo'<td class=" "> <button type="button" style="width:70px;" class="btn btn-success btn-xs">مدفوعة</button></td>';
									else
							echo'<td class=" "> <button type="button" style="width:70px;" class="btn btn-warning btn-xs">غير مدفوعة</button></td>';
									
                                    echo'<td class="a-right a-right "> ريال   '.$row_P['Cost'].'  </td>
                                    <td class=" last"><a href="invoice.php?id='.$row_P['idCart'].'"> <button type="button" class="btn btn-primary btn-xs">عرض</button></a>
                                    <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row_P['idCart'].');"><i class="fa fa-trash-o"></i> حذف </a>            
                                                    </td>
                                            </tr>';
							}
							else
							{
							
							  echo'    <tr class="even pointer" >
                                    <td class="a-center "><input type="checkbox" class="flat" name="table_records" ></td>
                                    <td class=" ">'.$row_P['idCart'].'</td>
                                    <td class=" ">'.$row_P['Date'].' </td>
                                    <td class=" ">'.$row_P['Mobile'].' </td>
                                   <td class=" "><a href="Profile.php?id='.$row_P['idUser'].'">'.$row_P['Name'].'</a></td>';
									if ($row_P['Done']==2)
                                    echo'<td class=" "> <button type="button" style="width:70px;" class="btn btn-success btn-xs">مدفوعة</button></td>';
									else
								echo'<td class=" "> <button type="button" style="width:70px;" class="btn btn-warning btn-xs">غير مدفوعة</button></td>';
									
                                    echo'<td class="a-right a-right "> ريال   '.$row_P['Cost'].'  </td>
                                    <td class=" last"><a href="invoice.php?id='.$row_P['idCart'].'"> <button type="button" class="btn btn-primary btn-xs">عرض</button></a>
                                    <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row_P['idCart'].');"><i class="fa fa-trash-o"></i> حذف </a>            
                                                    </td>
                                            </tr>';
								
							}
								  }
								  echo'
                                            
                                            
                                            
                                           
                                            </tbody>

                                    </table>
		
		';
                                           

?>

