<?php include("Check.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
</head>

<body>


<?php
$dir='../image/Logo';
$handle=opendir($dir);

while (($file = readdir($handle))!==false) {
@unlink($dir.'/'.$file);
}
closedir($handle);

include("../include/dataconnect.php");



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
	                            echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Logo.php'>";
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
             move_uploaded_file($_FILES["Image"]["tmp_name"],"../image/Logo/$filename");
																
																	
			$sql="UPDATE  home  SET Logo='$filename'";																
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
	echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Logo.php'>";
		}
														
																	
																  }
														 }
										 }
								}
				 }
				 else
				 {
					 		 $_SESSION['Done']=0;
	                          echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Logo.php'>";
				 }
	  }
	  else
	  {  
   
   
   
    $_SESSION['Done']=0;
	echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Logo.php'>";
	  }				
					

?>
	



</body>
</html>