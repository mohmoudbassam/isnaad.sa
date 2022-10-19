<?php include("Check.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body>

<?php

$Link=$_POST['Link'];
$Name=$_POST['Name'];								

					                                               
			$sql="INSERT INTO video(Name,Link)VALUES('$Name','$Link')";
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
			echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Video.php'>";	
        }
														
		



							
?>
</body>
</html>


