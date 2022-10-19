<?php session_start();?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../include/dataconnect.php");
// Security one

$id=$_GET["id"];
$New=$_GET["New"];


$result66=mysql_query("DELETE FROM comment 
where idComment=$id",$link);


 
	    echo'
		
		
		 <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                        <thead>
                                            <tr class="headings">
                                                <th>
                                                    <input type="checkbox" id="check-all" class="flat">
                                                </th>
                                                <th class="column-title">رقم التعليق </th>
                                                <th class="column-title">إسم المعلق </th>
                                                <th class="column-title">حالة التعليق </th>
                                                <th class="column-title">التعليق </th>
                                                <th class="column-title no-link last"><span class="nobr"></span>
                                                </th>
                                                <th class="bulk-actions" colspan="7">
                                                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                                 </th>
                                </tr>
                            </thead>

                            <tbody>
                            '; 
								
								
								
								
								$sql_P="select  comment.idComment as idComment,comment.Info as Info,comment.Seen as Seen,comment.Sho as Sho,user.Name as User,user.idUser as idUser,news.Name as News,news.idNews as idNews from comment 
								inner join user
								on comment.F_User=user.idUser 
								inner join news
								on comment.F_New=news.idNews 
								where comment.F_New=$New
								order by idComment DESC";
                                $result_P=mysql_query($sql_P,$link);
								while($row_P=@mysql_fetch_array($result_P))
				                  {
                            
                         
                            if ($row_P['Seen']==1)
							{
                            echo'    <tr class="even pointer" style="background:#fff5cd;">
                                    <td class="a-center "><input type="checkbox" class="flat" name="table_records" ></td>
                                    <td class=" ">'.$row_P['idComment'].'</td>
                                    <td class=" "><a href="Profile.php?id='.$row_P['idUser'].'">'.$row_P['User'].'</a></td>
									';
									if ($row_P['Sho']==2)
                                    echo'<td class=""> <button onclick="Co('.$row_P['idComment'].','.$New.');" type="button" style="width:70px;" class="btn btn-success btn-xs">ظاهر</button></td>';
									else
							        echo'<td class=""> <button onclick="Co('.$row_P['idComment'].','.$New.');" type="button" style="width:70px;" class="btn btn-warning btn-xs">مخفي</button></td>
									
									
									';
									
                                    echo'
									 <td class=" ">'.$row_P['Info'].'</td>
                                    <td class=" last">
                                    <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row_P['idComment'].','.$New.');"><i class="fa fa-trash-o"></i> حذف </a>            
                                                    </td>
                                            </tr>';
							}
							else
							{
							
							  echo'   <tr class="even pointer" >
                                    <td class="a-center "><input type="checkbox" class="flat" name="table_records" ></td>
                                    <td class=" ">'.$row_P['idComment'].'</td>
                                    <td class=" "><a href="Profile.php?id='.$row_P['idUser'].'">'.$row_P['User'].'</a></td>
									
									
									';
									if ($row_P['Sho']==2)
                                    echo'<td class=""> <button onclick="Co('.$row_P['idComment'].','.$New.');" type="button" style="width:70px;" class="btn btn-success btn-xs">ظاهر</button></td>';
									else
							        echo'<td class=""> <button onclick="Co('.$row_P['idComment'].','.$New.');" type="button" style="width:70px;" class="btn btn-warning btn-xs">مخفي</button></td>
									
									
									';
									
                                    echo'
									 <td class=" ">'.$row_P['Info'].'</td>
                                    <td class=" last">
                                    <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row_P['idComment'].','.$New.');"><i class="fa fa-trash-o"></i> حذف </a>            
                                                    </td>
                                            </tr>';
								
							}
								  }
								echo'
                                            
                                            
                                            
                                           
                                            </tbody>

                                    </table>
		
		';
                                           

?>

