<?php include("Check.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body>

<?php
$id=$_POST['id'];
$Name=$_POST["Name"];
$Email=$_POST["email"];
$Username=$_POST["Username"];
$Password=$_POST["password"];
$Password=md5($Password);
$Mobile=$_POST["Mobile"];


						
	    $sql="UPDATE  admin  SET Name='$Name',Username='$Username',Password='$Password',Mobile='$Mobile',Email='$Email' Where idAdmin=$id";																
        $result=mysql_query($sql,$link);

			 if (!$result)
			  {	
			 $_SESSION['Done']=0;
															 
			echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Edit_Admin.php?id=$id'>";

			}	
			else
			{										
	 $_SESSION['Done']=1;
			echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Edit_Admin.php?id=$id'>";
											
			}
?>
	



</body>
</html>