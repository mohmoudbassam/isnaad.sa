<?php include("Check.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body>

<?php


$Val=$_POST["Val"];
$Date=date("Y/m/d");


if(isset($_SESSION['Cart_ID']))
	{
$F_Cart=$_SESSION['Cart_ID'];	
	}
	else
	{
 $_SESSION['Done']=0;

		echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Payments.php?idcart=".$F_Cart."'>";
	}
	

		                                                          
			$sql="INSERT INTO payment(Val,Date,F_Cart)VALUES('$Val','$Date','$F_Cart')";
			$result=mysql_query($sql,$link);	
			
			if (!$result)
			 {	
			 $_SESSION['Done']=0;
		echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Payments.php?idcart=".$F_Cart."'>";
	    	}
			else
			{
    	    $_SESSION['Done']=1;
			
			  $sql_Cart="select * from cart where idCart='$F_Cart' ";
                                 $result_Cart=mysql_query($sql_Cart,$link);
								 $row_Cart=mysql_fetch_array($result_Cart);
								 
								  $sql_Sum="SELECT SUM(Val) AS Cost FROM payment where F_Cart='$F_Cart'";
                                 $result_Sum=mysql_query($sql_Sum,$link);
								 $row_Sum=mysql_fetch_array($result_Sum);
								 
								 
	                             $sql_P="select * from payment where F_Cart='$F_Cart'";
                                 $result_P=mysql_query($sql_P,$link);
								 $rownum=@mysql_num_rows($result_P);
								 	
		if ( ($rownum > 0 ) && ( $row_Sum['Cost'] >= $row_Cart['Cost']) )
		{
		
			 $sql="UPDATE  cart  SET Done='2' Where idCart=$F_Cart";																
             $result=mysql_query($sql,$link);
			
			
		}
		else if  ($rownum > 0)
		{
		 $sql="UPDATE  cart  SET Done='3' Where idCart=$F_Cart";																
             $result=mysql_query($sql,$link);
			
			
		}
		
		else 
		{
		 $sql="UPDATE  cart  SET Done='1' Where idCart=$F_Cart";																
             $result=mysql_query($sql,$link);
				
		}
			
			
		echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Payments.php?idcart=".$F_Cart."'>";
	        }


                               
		
							
?>
</body>
</html>


