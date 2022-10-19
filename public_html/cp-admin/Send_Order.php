<?php session_start();  
include("include/dataconnect.php");
  
$idUser=$_SESSION['User']; 
$q_user="select * from user where idUser=$idUser";
$r_user=mysql_query($q_user,$link);
$row_user=@mysql_fetch_array($r_user);
$Email=$row_user['Email']; 


$Date=date("Y/m/d");
$sql1="INSERT INTO cart(F_User,Cost,Date,Done,Watch)VALUES('$idUser',0,'$Date',1,1)";
$result1=mysql_query($sql1,$link); 
if (!$result1)
	$OK=0;
	 
$ip=mysql_insert_id(); 
$_SESSION['idCart']=$ip;
$_SESSION['Agree']=1;

$Total=0;
$OK=1;
foreach($_SESSION['Cart'] as $x => $x_value) 
  {
	  
	 $q="select * from product where idProduct=$x";
     $r=mysql_query($q,$link);
     $row=@mysql_fetch_array($r);
     $Price=$row['Price'];  
	 $Cost=$Price*$x_value; 
	 $Total+=$Cost;
	$sql2="INSERT INTO orderr(F_Cart,F_Product,Amount,Cost)VALUES('$ip','$x','$x_value','$Cost')";
    $result2=mysql_query($sql2,$link); 
	if (!$result2)
	$OK=0;	
     
  } 
    $Total+=50;
    $sql="UPDATE  cart  SET Cost='$Total' Where idCart=$ip";																
    $result=mysql_query($sql,$link);
	
	
	
	
	$email_to =   'mothanna@shooub.com';
	$subject   =  "موقع الهدايا ";
	


$message1 = '<html><body>';
$message1 .= '<img src="//css-tricks.com/examples/WebsiteChangeRequestForm/images/wcrf-header.png" alt="Website Change Request" />';
$message1 .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
$message1 .= "<tr style='background: #eee;'><td><strong>المرسل:</strong> </td><td>موقع الهدايا</td></tr>";
$message1 .= "<tr><td><strong>البريد الإلكتروني:</strong> </td><td>info@shooub.com</td></tr>";

                   
						
   $Cart=$_SESSION['idCart'];
   $sql1="select * from orderr  where F_Cart='$Cart'";
   $result1=mysql_query($sql1,$link);
	                                      
          
   while($row1=@mysql_fetch_array($result1))
  {     
  $Product=$row1['F_Product'];
			    
$sql_p="SELECT product.Name,product.idProduct, product.Price,orderr.Amount,orderr.Cost,orderr.F_Product,orderr.idOrderr
FROM product
INNER JOIN orderr
ON product.idProduct=orderr.F_Product
where product.idProduct='$Product'
";
	    $result_p=mysql_query($sql_p,$link);
		$row_p=@mysql_fetch_array($result_p);

$message1 .= "<tr><td><strong>إسم المنتج:</strong> </td><td>".$row_p['Name']."</td></tr>";

	  }
$message1 .= "</table>";
$message1 .= "</body></html>";



    $headers  = "From: $email\r\n";	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
    $headers .= "Reply-To: The Sender <$email>\r\n"; 
    $headers .= "Return-Path: The Sender <info@shooub.com>\r\n";
    $headers .= "From: The Sender <info@shooub.com>\r\n"; 
    $headers .= "Organization: Sender Organization\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
	
	
	
	
    
    if(mail($email_to, $subject, $message1, $headers)){
       $OK=1;      
    }else{
       $OK=0;    
    }

	

if ( $OK == 1)
{
unset($_SESSION['pro']);
unset($_SESSION['Cart']);
unset($_SESSION['Table']);
unset($_SESSION['idCart']);
	
	
	echo '
	
	<div class="heading">
				<h3></h3>
				<br>
				<p style="text-align:center; direction:rtl;">لقد تم إستقبال طلبك وسوف تصلك رسالة على بريدك الإلكتروني <a href="mailto:'.$Email.'"> '.$Email.' </a> لتسديد فاتورة الطلبية , <a href="index.php">تابع التسوق معنا </a> </p>
				<br>
                <br>
			    </div>
	
	';
}

else
{
	echo '
	
	<div class="heading">
				<h3></h3>
				<br>
				<p style="text-align:center; direction:rtl; color:#C60000; ">لقد حدث خطأ ما أثناء إرسال الطلب , الرجاء المحاولة مرة أخرى</p>
				<br>
                <br>
			    </div>
	
	';	
	
}







?>



