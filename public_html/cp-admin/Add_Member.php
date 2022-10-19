<?php include("Check.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
$Info=$_POST["Info"];
$Info_E=$_POST["Info_E"];
$Mobile=$_POST["Mobile"];
$Company=$_POST["Company"];
$Facebook=$_POST["Facebook"];
$Twitter=$_POST["Twitter"];
$Instagram=$_POST["Instagram"];
$Youtube=$_POST["Youtube"];
$Linked=$_POST["Linked"];
$Google=$_POST["Google"];
$Sho=$_POST["Sho"];
$Gender=$_POST["Gender"];
$Point=0;	
$Type=$_POST["Type"];					
/*-------------------*/		
					
					function contains($substring, $string) 
					{
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
      { //1
          if ((($_FILES["Image"]["type"] == "image/gif")
           || ($_FILES["Image"]["type"] == "image/jpeg")
		   || ($_FILES["Image"]["type"] == "image/png")
		   || ($_FILES["Image"]["type"] == "image/PNG")
		   || ($_FILES["Image"]["type"] == "image/bmp")
		   || ($_FILES["file"]["type"] == "image/jpg")
		   || ($_FILES["file"]["type"] == "image/JPG")
		   || ($_FILES["file"]["type"] == "image/JPEG")
           || ($_FILES["Image"]["type"] == "image/pjpeg")))
                 { //2
                       if ($_FILES["Image"]["error"] > 0)
                                { //3
																												  																															                     $_SESSION['Done']=0;
					echo "<META HTTP-EQUIV='Refresh' Content='0;URL=New_Member.php'>";
								} //3
					  else
	                            { //4
                                    $filename="";
									$filenamethumb="";
							        if(!contains(".php",$_FILES["Image"]["name"])&&!contains(".pl",$_FILES["Image"]["name"]))
								         { //5
                                            $ext=$_FILES["Image"]["name"];
									        $name1=rand(1,999999999 );
                                            $filename=$name1.$ext;

											   if(!contains(".php",$filename)&&!contains(".pl",$filename))
								                         {
				 if(contains(".jpg",$filename)|| contains(".JPG",$filename)|| contains(".jpeg",$filename) || contains(".JPEG",$filename)||contains(".PNG",$filename)||contains(".png",$filename)||contains(".gif",$filename))
				 
								                                  { //6
                  move_uploaded_file($_FILES["Image"]["tmp_name"],"../image/User/$filename");
                                                                   
        			$sql="INSERT INTO user(Name,Name_E,Company,Type,Mobile,Email,Username,Password,Address,Address_E,Point,Image,Info,Info_E,Facebook,Twitter,Google,Linked,Youtube,Instagram,Sho,Gender,Seen)VALUES('$Name','$Name_E','$Company','$Type','$Mobile','$Email','$Username','$Password','$Address','$Address_E','$Point','$filename','$Info','$Info_E','$Facebook','$Twitter','$Google','$Linked','$Youtube','$Instagram','$Sho','$Gender','2')";
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
					      echo "<META HTTP-EQUIV='Refresh' Content='0;URL=New_Member.php'>";
						}
																	
																  }//6
														 }//5
										 }//4
								}//2
				 }//2
				 else
				 { //7
				 
			      $_SESSION['Done']=0;	 				
				  echo "<META HTTP-EQUIV='Refresh' Content='0;URL=New_Member.php'>";
				 }//7
	  } //1
	  else
	  {  //8 
	  
	  
	   if($Type==2)
	   {
	  if ($Gender==1)
	  $image="male.png";
	  else if ($Gender==2)
	  $image="female.png";
	   }
	   else
	   $image="1.png";
	   
	   
	       $sql="INSERT INTO user(Name,Name_E,Company,Type,Mobile,Email,Username,Password,Address,Address_E,Point,Image,Info,Info_E,Facebook,Twitter,Google,Linked,Youtube,Instagram,Sho,Gender,Seen)VALUES('$Name','$Name_E','$Company','$Type','$Mobile','$Email','$Username','$Password','$Address','$Address_E','$Point','$image','$Info','$Info_E','$Facebook','$Twitter','$Google','$Linked','$Youtube','$Instagram','$Sho','$Gender','2')";
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
			echo "<META HTTP-EQUIV='Refresh' Content='0;URL=New_Member.php'>";

		}
			 
	  }//8



			
								
							
?>
</body>
</html>


