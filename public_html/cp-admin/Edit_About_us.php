<?php include("Check.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
</head>

<body>


<?php

$About_as_E=$_POST["About_as_E"];
$About_as=$_POST["About_as"];


$Feature_E=$_POST["Feature_E"];
$Feature=$_POST["Feature"];

$Ourthinking_E=$_POST["Ourthinking_E"];
$Ourthinking=$_POST["Ourthinking"];

$Practical_E=$_POST["Practical_E"];
$Practical=$_POST["Practical"];

$Confidence_E=$_POST["Confidence_E"];
$Confidence=$_POST["Confidence"];

$Forgetting_E=$_POST["Forgetting_E"];
$Forgetting=$_POST["Forgetting"];


$Ourgrowth_E=$_POST["Ourgrowth_E"];
$Ourgrowth=$_POST["Ourgrowth"];


$Ourfocus_E=$_POST["Ourfocus_E"];
$Ourfocus=$_POST["Ourfocus"];
				
$Title=$_POST["Title"];
$Title_E=$_POST["Title_E"];
$Map=$_POST["Map"];
$Address=$_POST["Address"];
$Address_E=$_POST["Address_E"];
$Mobile=$_POST["Mobile"];
$Phone=$_POST["Phone"];
$Fax=$_POST["Fax"];
$Facebook=$_POST["Facebook"];
$Twitter=$_POST["Twitter"];
$Whatsapp=$_POST["Whatsapp"];
$Youtube=$_POST["Youtube"];
$Email=$_POST["Email"];
$Instagram=$_POST["Instagram"];
$Linkedin=$_POST["Linkedin"];
$Google=$_POST["Google"];



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
		  
		  $dir='../image/Home';
$handle=opendir($dir);

while (($file = readdir($handle))!==false) {
@unlink($dir.'/'.$file);
}
closedir($handle);

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
                                echo "<META HTTP-EQUIV='Refresh' Content='0;URL=About.php'>";
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
                                                                    move_uploaded_file($_FILES["Image"]["tmp_name"],"../image/Home/$filename");
																
																	
			$sql="UPDATE  home  SET About_as='$About_as',About_as_E='$About_as_E',Feature='$Feature',Feature_E='$Feature_E',Practical='$Practical',Practical_E='$Practical_E',Forgetting='$Forgetting',Forgetting_E='$Forgetting_E',Confidence='$Confidence',Confidence_E='$Confidence_E',Ourthinking='$Ourthinking',Ourthinking_E='$Ourthinking_E',Ourgrowth='$Ourgrowth',Ourgrowth_E='$Ourgrowth_E',Ourfocus='$Ourfocus',Ourfocus_E='$Ourfocus_E',Title='$Title',Title_E='$Title_E',Map='$Map',Address='$Address',Address_E='$Address_E',Mobile='$Mobile',Phone='$Phone',Fax='$Fax',Facebook='$Facebook',Twitter='$Twitter',Youtube='$Youtube',Linkedin='$Linkedin',Google='$Google',Instagram='$Instagram',Whatsapp='$Whatsapp',Email='$Email',image='$filename'";																
            $result=mysql_query($sql,$link);
			
			
            if ($result)
			 {												
	                     $_SESSION['Done']=1;
             }
          else
             {
                       $_SESSION['Done']=0;
												
             }
			 
	echo "<META HTTP-EQUIV='Refresh' Content='0;URL=About.php'>";
														
																	
																  }
														 }
										 }
								}
				 }
				 else
				 {
					 		 $_SESSION['Done']=0;
	                       echo "<META HTTP-EQUIV='Refresh' Content='0;URL=About.php'>";
				 }
	  }
	  else
	  {  
	  
	  	$sql="UPDATE  home  SET About_as='$About_as',About_as_E='$About_as_E',Feature='$Feature',Feature_E='$Feature_E',Practical='$Practical',Practical_E='$Practical_E',Forgetting='$Forgetting',Forgetting_E='$Forgetting_E',Confidence='$Confidence',Confidence_E='$Confidence_E',Ourthinking='$Ourthinking',Ourthinking_E='$Ourthinking_E',Ourgrowth='$Ourgrowth',Ourgrowth_E='$Ourgrowth_E',Ourfocus='$Ourfocus',Ourfocus_E='$Ourfocus_E',Title='$Title',Title_E='$Title_E',Map='$Map',Address='$Address',Address_E='$Address_E',Mobile='$Mobile',Phone='$Phone',Fax='$Fax',Facebook='$Facebook',Twitter='$Twitter',Youtube='$Youtube',Linkedin='$Linkedin',Google='$Google',Instagram='$Instagram',Whatsapp='$Whatsapp',Email='$Email'";			
	  
	  
	   $result=mysql_query($sql,$link);
if ($result) {

																	
	 $_SESSION['Done']=1;
}
else
{
$_SESSION['Done']=0;
												
	  }
	echo "<META HTTP-EQUIV='Refresh' Content='0;URL=About.php'>";
	  }				
					

?>
	



</body>
</html>