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
$Info=$_POST["Info"];
$Info_E=$_POST["Info_E"];
$Sho=$_POST["Sho"];
$Price=0;
$Visit=$_POST["Visit"];
$F_Customer=1;
$id=$_POST['id'];

			
		$sql="UPDATE project  SET Name='$Name',Name_E='$Name_E',Info='$Info',Info_E='$Info_E',Sho='$Sho',Price='$Price',Visit='$Visit',F_Customer='$F_Customer' Where idProject='$id'";
		  $result=mysql_query($sql,$link);
	


function contains($substring, $string) {
        $pos = strpos ($string, $substring);
 
        if($pos === false) {
                // string needle NOT found in haystack
                return false;
        }
        else {
                // string needle found in haystack
                return true;
        }
 
}

 if($_FILES["Image"]["size"]!=0)
      {
           if ((($_FILES["Image"]["type"] == "image/gif")
           || ($_FILES["Image"]["type"] == "image/jpeg")
		   || ($_FILES["Image"]["type"] == "image/png")
		   || ($_FILES["Image"]["type"] == "image/bmp")
           || ($_FILES["Image"]["type"] == "image/pjpeg")))
                 {
                       if ($_FILES["Image"]["error"] > 0)
                                {
																 $_SESSION['Done']=0;

	echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Project.php?id=$id'>";
								}
					  else
	                            {
                                    $filename="";
									$filenamethumb="";
							        if(!contains(".php",$_FILES["Image"]["name"])&&!contains(".pl",$_FILES["Image"]["name"]))
								         {
                                            $ext=substr($_FILES["Image"]["name"],strpos($_FILES["Image"]["name"],".")+1,3);
											
											$ext=strtolower($ext);
                                            $name1=rand(1,999999 );
										    $filenamethumb=$name1."-thumb.".$ext;
										  //  $filenamethumb2=$name1."-thumbb.".$ext;
                                            $filename=$name1.".".$ext;
											   if(!contains(".php",$filename)&&!contains(".pl",$filename))
								                         {
								                            if(contains(".jpg",$filename)||contains(".jpeg",$filename)||contains(".png",$filename)||contains(".gif",$filename))
								                                  {
                        move_uploaded_file($_FILES["Image"]["tmp_name"],"../image/Project/$filename");
																
				$sql3="select * from project_image Where F_Project= $id";
			$result3=mysql_query($sql3,$link);
			$i=1;
while($row3=@mysql_fetch_array($result3))
{
	$i++;
}		
																
																	
				$sql="INSERT INTO project_image(Name,Link,Num,F_Project)VALUES('$id','$filename',$i,$id)";
				$result=mysql_query($sql,$link);
				
				if (!$result)
				 {	
			 $_SESSION['Done']=0;

				 echo "<script type=\"text/javascript\">
             window.history.back();
            </script>";
	            	}
                 
				 else
				 {													
				  $_SESSION['Done']=1;
	              echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Project.php?id=$id'>";
				 }
														
																	
																  }
														 }
										 }
								}
				 }
				 else
				 {
			 $_SESSION['Done']=0;

	echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Project.php?id=$id'>";
				 }
	  }
	  else
	  { 

			 $_SESSION['Done']=1;

	echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Project.php?id=$id'>";
	  }				
					

?>
	



</body>
</html>