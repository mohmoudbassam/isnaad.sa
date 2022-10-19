<?php include("Check.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>New System</title>
</head>

<body>

<?php
$Name=$_POST["Name"];
$Name_E=$_POST["Name_E"];
$Sho=$_POST["Sho"];
	
				
	      $sql="INSERT INTO projsection(Name,Name_E,Sho)VALUES('$Name','$Name_E','$Sho')";
		  $result=mysql_query($sql,$link);	 
		  $_SESSION['Done']=1;
		  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=New_PSection.php">';


			 
	 

/*-------------------*/	


			
								
							
?>
</body>
</html>


