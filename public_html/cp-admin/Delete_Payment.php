<?php session_start();?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../include/dataconnect.php");
// Security one

$id=$_GET["id"];
$idcart=$_SESSION['Cart_ID'];

$result1=mysql_query("DELETE FROM payment where idPayment=$id",$link);


  $sql_Cart="select * from cart where idCart='$idcart' ";
                                 $result_Cart=mysql_query($sql_Cart,$link);
								 $row_Cart=mysql_fetch_array($result_Cart);
								 
								  $sql_Sum="SELECT SUM(Val) AS Cost FROM payment where F_Cart='$idcart'";
                                 $result_Sum=mysql_query($sql_Sum,$link);
								 $row_Sum=mysql_fetch_array($result_Sum);
								 
								 
	                             $sql_P="select * from payment where F_Cart='$idcart'";
                                 $result_P=mysql_query($sql_P,$link);
								 $rownum=@mysql_num_rows($result_P);
								 	
		if ( ($rownum > 0 ) && ( $row_Sum['Cost'] >= $row_Cart['Cost']) )
		{
		
			 $sql="UPDATE  cart  SET Done='2' Where idCart=$idcart";																
             $result=mysql_query($sql,$link);
			
			
		}
		else if  ($rownum > 0)
		{
		 $sql="UPDATE  cart  SET Done='3' Where idCart=$idcart";																
             $result=mysql_query($sql,$link);
			
			
		}
		
		else 
		{
		 $sql="UPDATE  cart  SET Done='1' Where idCart=$idcart";																
             $result=mysql_query($sql,$link);
				
		}


 
	    echo'

                                    <!-- start project list -->
                                    <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th >رقم الدفعة</th>
                                                <th >قيمة الدفعة</th>
                                                <th>تاريخ الدفعة</th>
                                               <th >#خيارات </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                         ';
										 $sql_P="select * from payment where F_Cart='$idcart' order by idPayment DESC ";
                                         $result_P=mysql_query($sql_P,$link);
								         while($row_P=@mysql_fetch_array($result_P))
										 {
                                            											
												
										 echo'
                                        
                                            <tr>
                                                <td>  <a href="">'.$row_P['idPayment'].'</a></td>
                                                <td>
                                                    <a href="" style="direction:rtl;">'.$row_P['Val'].' / ريال</a>
                                                   
                                                </td>
                                                <td>
                                                    <a href="">'.$row_P['Date'].'</a>
                                                   
                                                </td>
                                             
												
                                                <td>
                                                    <a href="Edit_Payment.php?id='.$row_P['idPayment'].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> تعديل </a>
                                      <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row_P['idPayment'].');"><i class="fa fa-trash-o"></i> حذف </a>                                                </td>
                                            </tr>';
										 }
										echo'
                                     
                                           
                                        </tbody>
                                    </table>
                                    <!-- end project list -->';
                                           

?>

