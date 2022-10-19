<?php include("Check.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
</head>

<body>


<?php
$Val=$_POST["Val"];

$x=is_numeric ($Val);
$id=$_POST['id'];
if(isset($_SESSION['Cart_ID']))
	{
$F_Cart=$_SESSION['Cart_ID'];	
	}
	else
	{
 $_SESSION['Done']=0;

		echo "<META HTTP-EQUIV='Refresh' Content='0;URL=index.php'>";
	}
	
if ($x)
{
     $sql="UPDATE  payment  SET Val='$Val' Where idPayment=$id";																
     $result=mysql_query($sql,$link);
	 
	 if (!$result) {	
			 $_SESSION['Done']=0;

				 echo "<script type=\"text/javascript\">
             window.history.back();
            </script>";
		}
		else
		{
        $_SESSION['Done']=1;
		echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Payments.php?idcart=".$F_Cart."'>";
		}
}
else
{
	 $_SESSION['Done']=0;	echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Payments.php?idcart=".$F_Cart."'>";
	
}
?>
	
</body>
</html>