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
$Sold=1;
$Company="Sanamway";
$Name_E=$_POST["Name_E"];
$Info=$_POST["Info"];
$Info_E=$_POST["Info_E"];
$Sho=$_POST["Sho"];
$Days=$_POST["D"];
$Price=$_POST["Price"];
$Link1=$_POST["Link1"];
$Link2=$_POST["Link2"];
$Link3=$_POST["Link3"];
$id=$_POST['id'];
$Tags="";
$Tags_E="";


$F_Catg=$_POST['Category'];	
	





                              $sql_P="select * from product where idProduct='$id'";
                              $result_P=mysql_query($sql_P,$link);
						      $row_P=mysql_fetch_array($result_P);
							  $E_Date=$row_P['E_Date'];
							  
							  
                                $x=$_SESSION['T'];
								
								
                               if($x >=0)
							   {
								if ($Days >= $x )  
								   {
									   $Y=$Days-$x;
									     $E_Date= date('Y/m/d',strtotime($E_Date.'+'.$Y.'days'));
								   }
								   else
							       {
									   
									     $Y=$x-$Days;
									     $E_Date= date('Y/m/d',strtotime($E_Date.'-'.$Y.'days'));  
							       }
								   
							  
							   }



	
	
			
		$sql="UPDATE product  SET Name='$Name',Company='$Company',Name_E='$Name_E',Info='$Info',Info_E='$Info_E',Sho='$Sho',Price='$Price',Link1='$Link1',Link2='$Link2',Link3='$Link3',F_Category='$F_Catg',E_Date='$E_Date' Where idProduct='$id'";
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
																 
																 
		echo "<script type=\"text/javascript\">
             window.history.back();
            </script>";

	//echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Product.php?id=$id'>";
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
																
				$sql3="select * from product_image Where F_Product= $id";
			$result3=mysql_query($sql3,$link);
			$i=1;
while($row3=@mysql_fetch_array($result3))
{
	$i++;
}		
																
																	
				$sql="INSERT INTO product_image(Name,Link,Num,F_Product)VALUES('$id','$filename',$i,$id)";
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
 echo "<script type=\"text/javascript\">
             window.history.back();
            </script>";
			}
	
	//echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Product.php?id=$id'>";
														
																	
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
	//echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Product.php?id=$id'>";
				 }
	  }
	  else
	  { 

			 $_SESSION['Done']=1;

   echo "<script type=\"text/javascript\">
             window.history.back();
            </script>";
	//echo "<META HTTP-EQUIV='Refresh' Content='0;URL=Product.php?id=$id'>";
	  }				
					
			}
?>
	



</body>
</html>