<?php include("Check.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body>

<?php

$Name=$_POST["Name"];
$Name_E=$_POST["Name_E"];
$Email=$_POST["email"];
$Username=$_POST["Username"];
$Password=$_POST["password"];
$Address=$_POST["Address"];
$Address_E=$_POST["Address_E"];
$Mobile=$_POST["Mobile"];
$Company=$_POST["Company"];
$id=$_POST['id'];
$Type=$_POST["Type"];
$Info=$_POST["Info"];
$Info_E=$_POST["Info_E"];
$Facebook=$_POST["Facebook"];
$Twitter=$_POST["Twitter"];
$Instagram=$_POST["Instagram"];
$Youtube=$_POST["Youtube"];
$Linked=$_POST["Linked"];
$Google=$_POST["Google"];
$Sho=$_POST["Sho"];
$Gender=$_POST["Gender"];



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
		   || ($_FILES["Image"]["type"] == "image/PNG")
		   || ($_FILES["Image"]["type"] == "image/bmp")
		   || ($_FILES["file"]["type"] == "image/jpg")
		   || ($_FILES["file"]["type"] == "image/JPG")
		   || ($_FILES["file"]["type"] == "image/JPEG")
           || ($_FILES["Image"]["type"] == "image/pjpeg")))
                 {
                       if ($_FILES["Image"]["error"] > 0)
                                {
		 $_SESSION['Done']=0;

	echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Profile.php?id=$id'>";
								}
					  else
	                            {
                                    $filename="";
									$filenamethumb="";
							        if(!contains(".php",$_FILES["Image"]["name"])&&!contains(".pl",$_FILES["Image"]["name"]))
								         {
                                            $ext=$_FILES["Image"]["name"];
									        $name1=rand(1,999999999 );
                                            $filename=$name1.$ext;

											   if(!contains(".php",$filename)&&!contains(".pl",$filename))
								                         {
				 if(contains(".jpg",$filename)|| contains(".JPG",$filename)|| contains(".jpeg",$filename) || contains(".JPEG",$filename)||contains(".PNG",$filename)||contains(".png",$filename)||contains(".gif",$filename))
				 
				 
								                                  {
                        move_uploaded_file($_FILES["Image"]["tmp_name"],"../image/User/$filename");
																
																	
	    $sql="UPDATE  user  SET  Linked='$Linked',Google='$Google',Youtube='$Youtube',Twitter='$Twitter',Facebook='$Facebook',Instagram='$Instagram',Name='$Name',Name_E='$Name_E',Company='$Company',Info='$Info',Info_E='$Info_E',Type='$Type',Sho='$Sho',Gender='$Gender',Username='$Username',Password='$Password',Mobile='$Mobile',Email='$Email',Address='$Address',Address_E='$Address_E',Image='$filename' Where idUser=$id";																
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
	         echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Profile.php?id=$id'>";
          }
														
																	
																  }
														 }
										 }
								}
				 }
				 else
				 {
             	    $_SESSION['Done']=0;
	                echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Profile.php?id=$id'>";
				 }
	  }
	  else
	  { 

		 $sql="UPDATE  user  SET Linked='$Linked',Google='$Google',Youtube='$Youtube',Twitter='$Twitter',Facebook='$Facebook',Instagram='$Instagram',Name='$Name',Name_E='$Name_E',Company='$Company',Info='$Info',Info_E='$Info_E',Address='$Address',Address_E='$Address_E',Type='$Type',Sho='$Sho',Gender='$Gender',Username='$Username',Password='$Password',Mobile='$Mobile',Email='$Email' Where idUser=$id";																
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
	      echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Profile.php?id=$id'>";
		}
	  }				
					

?>
	



</body>
</html>