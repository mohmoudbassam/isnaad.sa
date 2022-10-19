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
$Company="Saudi Art";
$Name_E=$_POST["Name_E"];
$Info=$_POST["Info"];
$Info_E=$_POST["Info_E"];
$Sho=$_POST["Sho"];
$Seen='2';
$Sold=$_POST["Sold"];
$Type=$_POST["Type"];
$Weight=0;
$Price=$_POST["Price"];
$Rate=0;
$Amount=1;
$Visit=0;
$F_User=$_POST["User"];
$Tags=$_POST["Tags"];
$Tags_E=$_POST["Tags_E"];

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

		                                                          
			$sql="INSERT INTO product(Name,Company,Name_E,Info,Info_E,Sho,Seen,Sold,Type,Weight,Price,Amount,Rate,Visit,F_User,F_Category,S_Date,E_Date,Tags,Tags_E)VALUES('$Name','$Company','$Name_E','$Info','$Info_E','$Sho','2','$Sold','$Type','$Weight','$Price','$Amount','$Rate','$Visit','$F_User','$F_Catg','$S_Date','$E_Date','$Tags','$Tags_E')";
			
			$result=mysql_query($sql,$link);	
			if (!$result) {	
			 $_SESSION['Done']=0;

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



    $max_size = 800; //max image size in Pixels
    $destination_folder = '../image/Product';
    $watermark_png_file = '../image/Logo/1.png'; //path to watermark image

 if($_FILES["image_file"]["size"]!=0)
      {
           if ((($_FILES["image_file"]["type"] == "image/gif")
           || ($_FILES["image_file"]["type"] == "image/jpeg")
		   || ($_FILES["image_file"]["type"] == "image/png")
		   || ($_FILES["image_file"]["type"] == "image/bmp")
           || ($_FILES["image_file"]["type"] == "image/pjpeg")))
                 {
                       if ($_FILES["image_file"]["error"] > 0)
                                {
																												  																															            $_SESSION['Done']=0;
																 															
				 echo "<script type=\"text/javascript\">
             window.history.back();
            </script>";

								}
					  else
	                            {
                                    $filename="";
									$filenamethumb="";
							        if(!contains(".php",$_FILES["image_file"]["name"])&&!contains(".pl",$_FILES["image_file"]["name"]))
								         {
                                           
								                
																	  
						
						
			  $image_name = $_FILES['image_file']['name']; //file name
			  $image_size = $_FILES['image_file']['size']; //file size
			  $image_temp = $_FILES['image_file']['tmp_name']; //file temp
			  $image_type = $_FILES['image_file']['type']; //file type	
			  
			    if(!contains(".php",$image_name)&&!contains(".pl",$image_name))
				 {
				if(contains(".jpg",$image_name)||contains(".jpeg",$image_name)||contains(".png",$image_name)||contains(".gif",$image_name))
			 {										  
																
			 switch(strtolower($image_type)){ //determine uploaded image type 
            //Create new image from file
            case 'image/png': 
                $image_resource =  imagecreatefrompng($image_temp);
                break;
            case 'image/gif':
                $image_resource =  imagecreatefromgif($image_temp);
                break;          
            case 'image/jpeg': case 'image/pjpeg':
                $image_resource = imagecreatefromjpeg($image_temp);
                break;
            default:
                $image_resource = false;
        }
    
    if($image_resource){
        //Copy and resize part of an image with resampling
        list($img_width, $img_height) = getimagesize($image_temp);
        
        //Construct a proportional size of new image
        $image_scale        = min($max_size / $img_width, $max_size / $img_height); 
        $new_image_width    = ceil($image_scale * $img_width);
        $new_image_height   = ceil($image_scale * $img_height);
        $new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);

        //Resize image with new height and width
        if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height))
        {
            
            if(!is_dir($destination_folder)){ 
                mkdir($destination_folder);//create dir if it doesn't exist
            }
            
            //calculate center position of watermark image
            $watermark_left = ($new_image_width/2)-(300/2); //watermark left
            $watermark_bottom = ($new_image_height/2)-(400/2); //watermark bottom

            $watermark = imagecreatefrompng($watermark_png_file); //watermark image

            //use PHP imagecopy() to merge two images.
            imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0,340, 454); //merge image
            
            //output image direcly on the browser.
              //header('Content-Type: image/jpeg');
              //imagejpeg($new_canvas, NULL , 90);
            
            //Or Save image to the folder
            imagejpeg($new_canvas, $destination_folder.'/'.$image_name , 100);
            
            //free up memory
            imagedestroy($new_canvas); 
            imagedestroy($image_resource);
            die();
        }
    }
															  
                 
                                                                   
			$sql="INSERT INTO product_image(Name,Link,Num,F_Product)VALUES($ip,'$image_name',1,$ip)";
			$result=mysql_query($sql,$link);
			if (!$result) 
			{
				 $_SESSION['Done']=0;
				 
				/* echo "<script type=\"text/javascript\">
             window.history.back();
            </script>";*/
			}
			else
			{
				 $_SESSION['Done']=1;
				 //echo "<META HTTP-EQUIV='Refresh' Content='0;URL=New_Product.php'>";

			}
																			  																															            

														
																	
																  }
														 }
										 }
								}
				 }
				 else
				 {
					 																			  																															 $_SESSION['Done']=0;

/* echo "<script type=\"text/javascript\">
             window.history.back();
            </script>";*/			
			
				 }
	  }
	  else
	  {   $image="1.jpg";
		

           $sql="INSERT INTO product_image(Name,Link,Num,F_Product)VALUES('$ip','$image',1,$ip)";
		   $result=mysql_query($sql,$link);		
		   $_SESSION['Done']=1;

		//  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=New_Product.php">';


			 
	  }



			
			}
							
?>
</body>
</html>


