<?php include("Check.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
</head>

<body>


<?php
$Name=$_POST["Name"];
$Name_E=$_POST["Name_E"];
$Sho=$_POST["Sho"];
$id=$_POST['id'];

     $sql="UPDATE  section  SET Name='$Name',Name_E='$Name_E',Sho='$Sho' Where idSection=$id";																
     $result=mysql_query($sql,$link);
    $_SESSION['Done']=1;
	echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Edit_Section.php?id=$id'>";
	
?>
	
</body>
</html>