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
$Company="Sanamway";
$Name_E=$_POST["Name_E"];
$Info=$_POST["Info"];
$Info_E=$_POST["Info_E"];
$Sho=$_POST["Sho"];
$Seen='2';
$Sold=1;
$Type=$_POST["Type"];
$Weight=0;
$Price=$_POST["Price"];
$Link1=$_POST["Link1"];    
$Link2=$_POST["Link2"];    
$Link3=$_POST["Link3"];    
$Rate=0;
$Amount=1;
$Visit=0;
$F_User=1;
$F_Brand=1;

$Tags="";
$Tags_E="";

if(isset($_SESSION['Catg']))
	{
$F_Catg=$_SESSION['Catg'];	
	}
	else
	$F_Catg=1;
	
	
	
	
	
$S_Date=date("Y/m/d");	

if ($Type==1)
{
$expire = time() + 30 * 24 * 60 *60;
$E_Date=date( "Y/m/d", $expire );
}
else if ($Type==2)
{
$expire = time() + 60 * 24 * 60 *60;
$E_Date=date( "Y/m/d", $expire );	
}
else if ($Type==3)
{
$expire = time() + 90 * 24 * 60 *60;
$E_Date=date( "Y/m/d", $expire );	
}
else if ($Type==0)
{
$E_Date=date("Y/m/d");		
}

		                                                          
			$sql="INSERT INTO product(Name,Company,Name_E,Info,Info_E,Sho,Seen,Sold,Type,Weight,Price,Link1,Link2,Link3,Amount,Rate,Visit,F_User,F_Brand,F_Category,S_Date,E_Date,Tags,Tags_E)VALUES('$Name','$Company','$Name_E','$Info','$Info_E','$Sho','2','$Sold','$Type','$Weight','$Price','$Link1','$Link2','$Link3','$Amount','$Rate','$Visit','$F_User','$F_Brand','$F_Catg','$S_Date','$E_Date','$Tags','$Tags_E')";
			
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
			
			
			
	    $ip=mysql_insert_id();

/*-------------------*/		
					
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
				/* $_SESSION['Done']=0;

				 echo "<script type=\"text/javascript\">
             window.history.back();
            </script>"; */

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
                  move_uploaded_file($_FILES["Image"]["tmp_name"],"../image/Product/$filename");
                                                                 
			$sql="INSERT INTO product_image(Name,Link,Num,F_Product)VALUES($ip,'$filename',1,$ip)";
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
			 echo "<META HTTP-EQUIV='Refresh' Content='0;URL=New_Product.php'>";

			}
																			  																															            

														
																	
																  }
														 }
										 }
								}
				 }
				 else
				 {
					 																			  																															       $_SESSION['Done']=0;
				 echo "<script type=\"text/javascript\">
             window.history.back();
            </script>";		
					 }
	  }
	  else
	  {   $image="1.jpg";
		

           $sql="INSERT INTO product_image(Name,Link,Num,F_Product)VALUES('$ip','$image',1,$ip)";
		   $result=mysql_query($sql,$link);		
		   $_SESSION['Done']=1;

		  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=New_Product.php">';


			 
	  }



			
			}
							
?>
</body>
</html>


